<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateDocumentationPdf extends Command
{
    protected $signature = 'docs:generate-pdf';
    protected $description = 'Generate the Arabic User Guide PDF';

    public function handle()
    {
        // Manually include the library if autoload fails
        require_once base_path('vendor/ar-php/ar-php/I18N/Arabic.php');

        $this->info('Generating Documentation PDFs...');

        $guides = [
            'pdf_admin_general' => 'Guide_Admin_National.pdf',
            'pdf_admin_regional' => 'Guide_Admin_Regional.pdf',
            'pdf_huissier' => 'Guide_Huissier_Justice.pdf',
        ];

        // START: Arabic Glyph Fixer
        $Arabic = new \I18N_Arabic('Glyphs');
        // END: Arabic Glyph Fixer

        foreach ($guides as $view => $filename) {
            try {
                $this->info("Generating {$filename}...");
                
                // 1. Render View to HTML string
                $html = view("documentation.{$view}")->render();

                // 2. Fix Arabic Glyphs SAFELY (Text nodes only, preserve HTML/CSS)
                $html = $this->fixArabicInHtml($html, $Arabic);

                // 3. Load fixed HTML into DomPDF
                $pdf = Pdf::loadHTML($html);
                $pdf->setPaper('a4', 'portrait');
                $pdf->setOptions([
                    'isPhpEnabled' => true, 
                    'isRemoteEnabled' => true, 
                    'defaultFont' => 'DejaVu Sans', // Better UTF-8 support
                    'isHtml5ParserEnabled' => true
                ]);
                
                $path = base_path("documentation/{$filename}");
                $pdf->save($path);
                $this->info("✔ Saved to: {$path}");
            } catch (\Exception $e) {
                $this->error("Error generating {$filename}: " . $e->getMessage());
            }
        }
        
        $this->info('All guides generated successfully.');
    }

    private function fixArabicInHtml($html, $arabic)
    {
        $dom = new \DOMDocument();
        
        // Fix for Google Fonts URL '&' or other unescaped entities causing DOM load error
        // Replaces & with &amp; if not already escaped (simple regex for URL parameters)
        $html = str_replace('&display=swap', '&amp;display=swap', $html);

        // Hack to load UTF-8 HTML correctly in DOMDocument
        // Suppress warnings for HTML5 tags
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);
        
        // Find all text nodes
        $textNodes = $xpath->query('//text()');

        foreach ($textNodes as $node) {
            $text = $node->nodeValue;
            // Apply fixer only if meaningful text and not inside script/style
            if (trim($text) !== '' && 
                $node->parentNode->nodeName !== 'style' && 
                $node->parentNode->nodeName !== 'script') {
                
                $fixedText = $arabic->utf8Glyphs($text);
                $node->nodeValue = $fixedText;
            }
        }

        // Save HTML and remove the XML Declaration added by the hack
        $output = $dom->saveHTML();
        $output = str_replace('<?xml encoding="UTF-8">', '', $output);
        
        return $output;
    }
}

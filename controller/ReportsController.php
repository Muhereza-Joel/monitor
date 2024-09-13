<?php

namespace controller;

use core\Request;
use model\Model;
use TCPDF;
use view\BladeView;

class ReportsController
{
    private $blade_view;
    private $model;
    private $app_name_full;
    private $app_name;
    private $base_url;

    public function __construct()
    {
        $this->blade_view = new BladeView();
        $this->model = Model::getInstance();
        $this->app_name_full = getenv("APP_NAME_FULL");
        $this->app_name = getenv("APP_NAME");
        $this->base_url = getenv("APP_BASE_URL");
    }

    public function export_single_pdf_report()
    {
        $request = Request::capture();
        $indicator_id = $request->input("indicator_id");

        $indicator_details = $this->model->get_indicator($indicator_id);
        $responses = $this->model->get_indicator_responses($indicator_id);
        $organisations = $this->model->get_organisations();

        $pdf = new CustomTCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('DataCities M & E Montor');
        $pdf->SetTitle('Indicator Report');
        $pdf->SetSubject('Indicator Report');
        $pdf->SetKeywords('Indicator, Report, DataCities');
        // Disable header and footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // Increase margins
        $pdf->setMargins(25, 20, 25); // Left, Top, Right margins in mm
        $pdf->setHeaderMargin(10); // Header margin in mm
        $pdf->setFooterMargin(10); // Footer margin in mm

        $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFont('helvetica', '', 10);

        $pdf->AddPage();
        date_default_timezone_set('Africa/Nairobi');

        // Set some content
        $html = $this->blade_view->render('pdfSingle', [
            'appNameFull' => $this->app_name_full,
            'appName' => $this->app_name,
            'currentDate' => date('Y-m-d h:i:s'),
            'currentTime' => date('h:i:s'),
            'indicatorDetails' => $indicator_details['response'],
            'responses' => $responses['response'],
            'organisations' => $organisations['response']
        ]);

        // Output the HTML content
        $pdf->writeHTML($html);

        // Ensure the directory exists
        $directory = __DIR__ . "/../uploads/reports/";
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        // Create a unique filename
        $filename = 'Indicator_Report_Single_' . time() . '.pdf';
        $file_path = $directory . '/' . $filename;

        // Save PDF to the specified directory
        $pdf->Output($file_path, 'F');

        // Create the full URL to the saved file
        $file_url = $this->base_url . '/uploads/reports/' . $filename;

        // Return the URL in the response
        $request->send_response(200, ['file_url' => $file_url]);
    }
}

class CustomTCPDF extends TCPDF
{
    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Add a border on top
        $this->Cell(0, 0, '', 'T', 0, 'C');
        // Footer text
        $this->Cell(0, 0, 'DataCities M & E Monitor', 0, 1, 'R');

        // Page number
        $this->Cell(0, 0, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

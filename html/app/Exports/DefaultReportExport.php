<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Throwable;

/**
 * Clase DefaultReportExport
 * @package App\Exports
 */
class DefaultReportExport implements FromView, WithEvents, ShouldAutoSize,WithColumnWidths
{
    /**
     * @var View
     */
    private $view;
    protected string $viewName;
    protected array $viewData;
    protected string $reporte;
    /**
     * Constructor ReportExport.
     *
     * @param View $view
     */
    public function __construct(string $viewName, array $viewData = [], string $reporte = "")
    {
        //$this->view = $view;
		$this->viewName = $viewName;
        $this->viewData = $viewData;
        $this->reporte = $reporte;
    }

    /**
     * Llama a la vista que se exportará a excel.
     *
     * @return View
     * @throws Throwable
     */
    public function view(): View
    {
         return view($this->viewName, $this->viewData);
    }

    /**
     * Modifica y aplica estilos a la hoja de excel.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $highestRowAndColumn = $event->sheet->getDelegate()->getHighestRowAndColumn();

                // Apply array of styles to A1:(last cell) cell range
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000']
                        ]
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER
                    ]
                ];
                $event->sheet->getDelegate()->getStyle('A1:' . $highestRowAndColumn['column'] . $highestRowAndColumn['row'])->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1:' . $highestRowAndColumn['column'] . $highestRowAndColumn['row'])->getAlignment()->setWrapText(true);

            },
        ];
    }

 	public function columnWidths(): array
    {
             \Illuminate\Support\Facades\Log::info('Ancho Columnas',['reporte' => $this->reporte]);
        switch($this->reporte){
            case "":
                    return [];
            break;
            case "Avance Presupuestario":
                 return [
                    'A' => 30,
                    'B' => 30,
                    'C' => 30,
                    'D' => 30,
                    'E' => 30,
                    'F' => 5,
                    'G' => 5,
                    'H' => 5,
                    'I' => 5,
                    'J' => 5,
                    'K' => 5,
                    'L' => 5,
                    'M' => 5,
                    'N' => 5,
                    'O' => 5,
                    'P' => 5,
                    'Q' => 5,

                    // Agrega más según la cantidad de columnas que tengas
                    ];
                break;
            case "Seguimiento Presupuestario":
                 return [
                    'A' => 25,
                    'B' => 40,
                    'C' => 40,
                    'D' => 40,
                    'E' => 40,
                    'F' => 40,
                    'G' => 10,
                    'H' => 10,
                    'I' => 10,
                    'J' => 40,
                    'K' => 40,
                    'L' => 14,
                    'M' => 12,
                    'N' => 10,
                    'O' => 10,
                    'P' => 12,
                    'Q' => 10,
                    'R' => 10,
                    'S' => 10,
                    'T' => 20,
                    'U' => 40,
                    'V' => 62,
                    'W' => 16,
                    'X' => 16,
                    'Y' => 16,
                    'Z' => 16,
					'AA' => 10,
                    'AB' => 12,
                    'AC' => 10,
                    'AD' => 10,
                    'AE' => 10,
                    'AF' => 12,
                    'AG' => 10,
                    'AH' => 10,
                    'AI' => 10,
                    'AJ' => 12,
                    'AK' => 10,
                    'AL' => 10,
                    'AM' => 10,
                    'AN' => 12,
                    'AO' => 12,
                    'AP' => 12,
                    // Agrega más según la cantidad de columnas que tengas
                    ];
                break;
                case "Cedula Presupuestaria":
                 return [
                    'A' => 62,
                    'B' => 60,
                    'C' => 16,
                    'D' => 16,
                    'E' => 16,
                    'F' => 16,
                    'G' => 16,
                    'H' => 16,
                    'I' => 16,
                    'J' => 16,
                    'K' => 16,             
                    // Agrega más según la cantidad de columnas que tengas
                    ];
                break;
                   case "ReviAprobPartidasPresupestarias":
                 return [
                    'A' => 62,
                    'B' => 60,
                    'C' => 60,
                    'D' => 60,
                    'E' => 16,
                               
                    // Agrega más según la cantidad de columnas que tengas
                    ];
                break;
                 case "Plan Anual de Compras":
                 return [
                    'A' => 6,
                    'B' => 34,
                    'C' => 12,
                    'D' => 20,
                    'E' => 40,
                    'F' => 10,
                    'G' => 10,
                    'H' => 10,
                    'I' => 40,
                    'J' => 40,
                    'K' => 40,
                    'L' => 18,
                    'M' => 14,
                    'N' => 30,
                    'O' => 10,
                    'P' => 20,
                    'Q' => 20,
                    'R' => 20,
                    'S' => 24,
                               
                    // Agrega más según la cantidad de columnas que tengas
                    ];
                break;
            default:
                return [];
            break;
        }
    }
}


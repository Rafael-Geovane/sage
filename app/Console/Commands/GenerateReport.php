<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sage:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a fake sensor data report spreadsheet (CSV)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Gerando relatório falso de sensores...');

        // Pasta e nome do arquivo
        $filename = 'relatorio_sensores_' . date('Y_m_d_His') . '.csv';
        $path = public_path('reports');
        
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $filepath = $path . '/' . $filename;
        $file = fopen($filepath, 'w');

        // Adiciona BOM para o Excel abrir o UTF-8 corretamente
        fputs($file, "\xEF\xBB\xBF");

        // Cabeçalhos
        fputcsv($file, [
            'ID Dispositivo', 
            'Paciente', 
            'Data/Hora', 
            'Freq. Cardíaca (BPM)', 
            'SpO2 (%)', 
            'Temperatura (°C)', 
            'Quedas Detectadas', 
            'Categoria do Evento', 
            'Status'
        ], ';');

        // Dados falsos
        $pacientes = ['Maria Santos', 'João Oliveira', 'Helena Costa', 'Antônio Rocha', 'Zilda Nunes'];
        $categorias = ['Monitoramento', 'Monitoramento', 'Monitoramento', 'Alerta Cardíaco', 'Queda'];
        
        for ($i = 0; $i < 50; $i++) {
            $paciente = $pacientes[array_rand($pacientes)];
            $categoria = $categorias[array_rand($categorias)];
            
            $bpm = rand(60, 110);
            $spo2 = rand(92, 99);
            $temp = rand(358, 375) / 10;
            $quedas = ($categoria == 'Queda') ? 1 : 0;
            
            if ($categoria == 'Alerta Cardíaco') {
                $bpm = rand(110, 140);
            }

            fputcsv($file, [
                'SGE-00' . rand(10, 99),
                $paciente,
                date('d/m/Y H:i:s', strtotime('-' . rand(1, 48) . ' hours')),
                $bpm,
                $spo2,
                number_format($temp, 1, ',', '.'),
                $quedas,
                $categoria,
                ($bpm > 100 || $spo2 < 94 || $temp > 37.5 || $quedas > 0) ? 'Alerta' : 'Normal'
            ], ';');
        }

        fclose($file);

        $this->info("Relatório gerado com sucesso em: public/reports/{$filename}");
        $this->info("Acesse pelo navegador em: http://127.0.0.1:8000/reports/{$filename}");
    }
}

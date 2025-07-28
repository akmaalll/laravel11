<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NaiveBayesService;
use App\Models\NaiveBayesTrainingData;

class TrainNaiveBayesModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'naive-bayes:train {--force : Force retrain even if model exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Train Naive Bayes model for dosen pembimbing recommendation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting Naive Bayes Model Training...');

        try {
            // Check if we have training data
            $trainingDataCount = NaiveBayesTrainingData::count();

            if ($trainingDataCount === 0) {
                $this->warn('⚠️  No training data found!');
                $this->info('Please add some training data first using the seeder:');
                $this->info('php artisan db:seed --class=NaiveBayesSeeder');
                return 1;
            }

            $this->info("📊 Found {$trainingDataCount} training data records");

            // Initialize service
            $naiveBayesService = new NaiveBayesService();

            // Train the model
            $this->info('🧠 Training model...');
            $result = $naiveBayesService->trainModel();

            if ($result) {
                $this->info('✅ Model trained successfully!');
                $this->info('🎯 Model is ready for recommendations');

                // Show some statistics
                $this->showTrainingStats();

                return 0;
            } else {
                $this->error('❌ Failed to train model');
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('❌ Error during training: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Show training statistics
     */
    private function showTrainingStats()
    {
        $this->newLine();
        $this->info('📈 Training Statistics:');

        $stats = [
            'Total Training Data' => NaiveBayesTrainingData::count(),
            'Successful Supervisions' => NaiveBayesTrainingData::where('hasil_pembimbingan', 'berhasil')->count(),
            'Less Successful' => NaiveBayesTrainingData::where('hasil_pembimbingan', 'kurang_berhasil')->count(),
            'Failed Supervisions' => NaiveBayesTrainingData::where('hasil_pembimbingan', 'gagal')->count(),
        ];

        foreach ($stats as $label => $count) {
            $this->line("  {$label}: {$count}");
        }

        $this->newLine();
        $this->info('💡 Usage:');
        $this->line('  - Access assignment page: /admin/pembimbing/assignment');
        $this->line('  - Test recommendations: /admin/pembimbing/naive-bayes-test');
        $this->line('  - API endpoint: /admin/pembimbing/recommendation-naive-bayes/{pengajuanId}');
    }
}

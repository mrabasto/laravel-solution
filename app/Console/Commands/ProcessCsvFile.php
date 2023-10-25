<?php

namespace App\Console\Commands;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ProcessCsvFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process source.csv from public storage';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $storage = 'public';
        $csv = 'source.csv';
        if (Storage::disk($storage)->exists($csv)) {
            $fileContents = Storage::disk($storage)->get($csv);
            $lines = explode(PHP_EOL, $fileContents);
            $column = explode(',', array_shift($lines));
            array_pop($lines);
            $column[0] = str_replace("\u{FEFF}", '', $column[0]);
            $column[2] = explode(' ', $column[2])[0];

            $album = [
                'name',
                'year',
                'sales',
                'release_date'
            ];

            $mappedData = [];


            foreach ($lines as $line) {
                [$artist, $albumName, $numSales, $releaseDate] = explode(',', $line);

                $hasArtist = array_key_exists($artist, $mappedData);

                if (!$hasArtist) {
                    $mappedData[$artist] = [];
                }

                $hasAlbum = array_key_exists($albumName, $mappedData[$artist]);

                if (!$hasAlbum) {
                    $mappedData[$artist][$albumName] = [];
                }

                $hasSales = array_key_exists('2022', $mappedData[$artist][$albumName]);

                // $hasRelease = array_key_exists($releaseDate, $mappedData[$artist][$albumName]);

                $mappedData[$artist][$albumName]['release_date'] = $releaseDate;

                $sales = $numSales;

                if ($hasArtist && $hasAlbum && $hasSales) {
                    $sales = $mappedData[$artist][$albumName]['2022'];
                    $sales += $numSales;
                }

                $mappedData[$artist][$albumName]['2022'] = $sales;
            }

            foreach ($mappedData as $artist => $albums) {
                $artist = Artist::factory()->create(['name' => $artist]);

                foreach ($albums as $name => $content) {
                    $album = Album::factory()->for($artist)->create([
                        'name' => $name,
                        'sales' => (int) $content['2022'],
                        'year' => '2022',
                        'release_date' => $content['release_date'],
                    ]);
                }

                $this->info("Processing data > Artist: {$artist->name}, Album: {$album->name}");
            }


            $this->info('CSV file processed successfully.');

            $artistCount = Artist::count();
            $albumCount = Album::count();

            $this->info("Artists: {$artistCount}, Albums: {$albumCount}");
        } else {
            $this->error('The CSV file does not exist in the public storage.');
        }
    }
}

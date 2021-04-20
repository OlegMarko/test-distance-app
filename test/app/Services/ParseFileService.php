<?php

namespace App\Services;

use App\Models\Route;
use App\Models\RouteInfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ParseFileService
{
    /**
     * @param UploadedFile $file
     * @return string
     */
    public static function parseFile(UploadedFile $file): string
    {
        $data = File::get($file->getRealPath());
        $dataByLines = explode("\n", $data);
        foreach ($dataByLines as $line) {
            if (strlen($line)) {
                $routeName = substr($line, 0, strpos($line, ":"));

                if (trim($routeName)) continue;

                $route = Route::firstOrCreate(
                    ['name' => $routeName], []
                );

                $distances = trim(substr($line, strpos($line, ":") + 1));
                $distances = trim($distances, '[');
                $distances = trim($distances, ']');
                $parsedDistances = explode(",", $distances);

                foreach ($parsedDistances as $distance) {
                    $parsedDistance = explode(":", $distance);

                    $distanceRoute = Route::firstOrCreate(
                        ['name' => trim($parsedDistance[0])], []
                    );

                    if (isset($parsedDistance[1])) {
                        RouteInfo::updateOrCreate(
                            ['start' => $route->id, 'end' => $distanceRoute->id],
                            ['distance' => trim($parsedDistance[1])]
                        );
                    }
                }
            }
        }

        return "All data parsed!";
    }
}

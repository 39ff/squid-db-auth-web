<?php

namespace App\Http\Requests\SquidUser;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class BulkImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Gate $gate): bool
    {
        return $gate->allows('create-squid-user', $this->user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
            'operation' => 'required|in:create,update,delete',
        ];
    }

    public function parseCsv(): array
    {
        $file = $this->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        if ($handle === false) {
            throw new \RuntimeException('Failed to open CSV file');
        }

        $rows = [];
        $header = null;
        $lineNumber = 0;

        try {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $lineNumber++;

                if ($header === null) {
                    $header = array_map('trim', $data);
                    continue;
                }

                // Skip empty lines
                if (empty(array_filter($data))) {
                    continue;
                }

                // Ensure column count matches header
                if (count($data) !== count($header)) {
                    throw new \RuntimeException(
                        "Line {$lineNumber}: Column count mismatch. Expected " . count($header) . " columns, got " . count($data)
                    );
                }

                $row = array_combine($header, array_map('trim', $data));
                if ($row !== false) {
                    $rows[] = $row;
                }
            }
        } finally {
            fclose($handle);
        }

        if (empty($rows)) {
            throw new \RuntimeException('CSV file is empty or contains no valid data rows');
        }

        return $rows;
    }
}

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
        return $gate->allows('create-squid-user', $this->route()->parameter('user_id'));
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

        $rows = [];
        $header = null;

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if ($header === null) {
                $header = $data;
                continue;
            }

            $row = array_combine($header, $data);
            if ($row !== false) {
                $rows[] = $row;
            }
        }

        fclose($handle);

        return $rows;
    }
}

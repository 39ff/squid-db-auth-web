<?php

namespace App\UseCases\SquidUser;

use App\Models\SquidUser;
use Illuminate\Support\Facades\DB;

class BulkCreateAction
{
    public function __invoke(array $rows, int $userId): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        DB::beginTransaction();

        try {
            foreach ($rows as $index => $row) {
                $squidUser = new SquidUser([
                    'user' => $row['user'] ?? '',
                    'password' => $row['password'] ?? '',
                    'enabled' => $row['enabled'] ?? 1,
                    'fullname' => $row['fullname'] ?? '',
                    'comment' => $row['comment'] ?? '',
                ]);
                $squidUser->user_id = $userId;
                $squidUser->save();

                $results['success']++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $results['failed'] = count($rows);
            $results['success'] = 0;
            $results['errors'][] = $e->getMessage();
        }

        return $results;
    }
}

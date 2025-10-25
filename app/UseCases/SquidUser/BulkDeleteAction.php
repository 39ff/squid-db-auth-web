<?php

namespace App\UseCases\SquidUser;

use App\Models\SquidUser;
use Illuminate\Support\Facades\DB;

class BulkDeleteAction
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
                $squidUser = SquidUser::query()
                    ->where('user', $row['user'] ?? '')
                    ->where('user_id', $userId)
                    ->first();

                if (!$squidUser) {
                    throw new \Exception("Row " . ($index + 2) . ": User '{$row['user']}' not found");
                }

                $squidUser->delete();
                $results['success']++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $results['failed'] = count($rows) - $results['success'];
            $results['errors'][] = $e->getMessage();
        }

        return $results;
    }
}

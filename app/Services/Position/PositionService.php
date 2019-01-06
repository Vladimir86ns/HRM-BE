<?php

namespace App\Services\Position;

use App\Position;
use Illuminate\Support\Facades\DB;

class PositionService
{
    const GET_POSITIONS_NUMBER_PER_PAGE = 10;

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function bulkSavePositions(array $attributes)
    {
        DB::transaction(function () use ($attributes) {
            foreach ($attributes['positions'] as $position) {
                foreach ($position['names'] as $name) {
                    Position::create([
                        'name' => $name,
                        'company_id' => $position['company_id'],
                        'department_id' => $position['department_id']
                    ]);
                }
            }
        });
        $companyId = $attributes['company_id'];

        return $this->getPositionsByCompanyId($companyId);
    }

    /**
     * @param int $companyId
     *
     * @return mixed
     */
    public function getPositionByIdAndCompanyId(int $id, int $companyId)
    {
        return Position::where([['company_id', $companyId], ['id', $id]])->first();
    }

    /**
     * @param int $companyId
     *
     * @return mixed
     */
    public function getPositionsByCompanyId(int $companyId)
    {
        return Position::where('company_id', $companyId)->get();
    }

    /**
     * Get all company positions.
     *
     * @param $companyId
     * @return mixed
     */
    public function getAllCompanyPositionsAsPaginator($companyId)
    {
        return Position::where('company_id', $companyId)->paginate(self::GET_POSITIONS_NUMBER_PER_PAGE);
    }
}

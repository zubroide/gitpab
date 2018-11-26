<?php

use App\Model\Entity\PaymentStatus;
use App\Providers\AppServiceProvider;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Throwable
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $paymentStatuses = [
                [
                    'alias' => PaymentStatus::PAYED,
                    'title' => 'messages.Payed',
                    'description' => 'messages.Payment completed',
                ],
                [
                    'alias' => PaymentStatus::CANCEL,
                    'title' => 'messages.Cancel',
                    'description' => 'messages.Added by mistake or occurs problem with payment',
                ],
            ];

            /** @var \App\Model\Service\Eloquent\EloquentPaymentStatusService $paymentStatusService */
            $paymentStatusService = app(AppServiceProvider::ELOQUENT_PAYMENT_STATUS_SERVICE);

            foreach ($paymentStatuses as $status) {
                $paymentStatusService->create($status);
            }

            DB::commit();
        }
        catch (\Throwable $e) {
            DB::rollback();
            // Skip seeder if at least one duplicate found
            if (!($e instanceof QueryException && $e->getCode() == 23505)) {
                throw $e;
            }
        }
    }
}

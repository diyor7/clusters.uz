<?php

namespace frontend\modules\cron\controllers;

use common\models\Auction;
use common\models\Contract;
use yii\web\Controller;

/**
 * Default controller for the `cron` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAuction()
    {
        $models = Auction::find()->where(['auction.status' => Auction::STATUS_ACTIVE])
            ->andWhere(['<=', 'auction.auction_end', date("Y-m-d H:i:s")])->all();

        foreach ($models as $model) {
            if ($model->currentRequest) {
                $model->currentRequest->is_winner = 1;
                $model->currentRequest->save(false);

                $contract = new Contract([
                    'customer_id' => $model->company_id,
                    'producer_id' => $model->currentRequest->company_id,
                    'auction_id' => $model->id,
                    'price' => $model->currentPrice,
                    'customer_signed' => 1,
                    'producer_signed' => 1,
                    'status' => Contract::STATUS_WAITING_PAYMENT_FROM_CUSTOMER
                ]);

                $contract->save();
            }

            $model->status = Auction::STATUS_FINISHED;
            $model->save(false);
        }
    }
}

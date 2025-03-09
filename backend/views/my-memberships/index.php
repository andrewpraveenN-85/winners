<?php

use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\MembershipsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'My Memberships';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberships-index">
    <p>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">
            Membership Card
        </button>
    </p>
    <div class="row">
        <div class="col-6">
            <?=
            DetailView::widget([
                'model' => $package,
                'attributes' => [
                    'name',
                    'description',
                    'duration',
                    'entry_point',
                    'eventText',
                    'merchants_discount'
                ],
            ])
            ?>
        </div>
        <div class="col-6">
            <?=
            DetailView::widget([
                'model' => $membership,
                'attributes' => [
                    'statusText',
                    [
                        'label' => 'Registered',
                        'value' => function ($data) {
                                return date("Y-m-d", $data->created_at);
                        }
                    ],
                    [
                        'label' => 'Ecpire',
                        'value' => function ($data) {
                            if ($data->package->duration == 'monthly') {
                                return date("Y-m-d", strtotime("+1 month", $data->created_at));
                            }
                            if ($data->package->duration == 'yearly') {
                                return date("Y-m-d", strtotime("+1 year", $data->created_at));
                            }
                        }
                    ]
                ],
            ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'format' => ['html'],
                        'value' => function ($data) {
                            return Html::img($data->imgURL, ['class' => 'img-fluid', 'style' => 'height: 100px;']); // options of size there
                        },
                    ],
                    [
                        'attribute' => 'merchant.bussiness_name',
                        'label' => 'Merchant',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="modalLabel">Membership Card</h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <?php
                    if ($package->duration == 'monthly') {
                        $expire = date("Y-m-d", strtotime("+1 month", $membership->created_at));
                    }
                    if ($package->duration == 'yearly') {
                        $expire = date("Y-m-d", strtotime("+1 year", $membership->created_at));
                    }
                    ?>

                    <div class="card-container">
                        <img src="/media/logo.png" alt="Logo" class="logo">
                        <div class="header"><?= $package->name; ?></div>
                        <div class="profile-section">
                            <img src="<?= $profile->imgURL; ?>" alt="Profile Picture" class="profile-img">
                            <div class="profile-name">
                                <strong><?= $profile->first_name . ' ' . $profile->last_name; ?></strong>
                            </div>
                        </div>
                        <div class="info-section">
                            <p>Expiry on: <strong><?= $expire; ?></strong></p>
                            <p>Member No: <strong>M<?= str_pad($profile->id, 6, "0", STR_PAD_LEFT); ?></strong></p>
                            <p>NIC/DL/PP No: <strong><?= $profile->sin; ?></strong></p>
                            <p>Contact No: <strong><?= $profile->mobile; ?></strong></p>
                        </div>
                        <div class="position-absolute bottom-0 end-0 p-2">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=50x50&data=<?= $profile->id; ?>" alt="QR Code" class="qr-code">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="printCard()">Print Card</button>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .card-container {
        width: 85.6mm; /* Credit card width */
        height: 53.98mm; /* Credit card height */
        background-color: #c79c31;
        border-radius: 10px;
        padding: 10px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-size: 12px;
        color: black;
        position: relative;
        text-align: center;
    }

    .header {
        background-color: black;
        color: white;
        font-weight: bold;
        padding: 5px;
        position: absolute;
        top: 10px;
        left: 50px; /* Starts from the middle of the logo */
        right: 10px;
        text-align: center;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .profile-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 40px; /* Adjust based on layout */
    }

    .profile-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-bottom: 5px;
    }

    .profile-name {
        font-size: 14px;
        font-weight: bold;
    }

    .info-section {
        text-align: left;
        margin-top: 5px;
    }

    .info-section p {
        font-size: 10px; /* Reduced text size */
        margin-bottom: 2px;
    }

    .qr-code {
        width: 50px;
        height: 50px;
    }

    .logo {
        width: 40px;
        height: 40px;
        position: absolute;
        top: 5px;
        left: 5px;
    }

    p {
        margin-bottom: 2px;
    }
</style>
<?php
$this->registerJs("
    $(document).ready(function() {
        // JavaScript function for printing the card
        window.printCard = function() {
            // Clone the card-container element to ensure we print the exact content
            var cardToPrint = $('.card-container').clone()[0];

            // Create a new window for printing
            var printWindow = window.open('', '', 'height=600,width=800');
            
            // Add styles to the print window to ensure the card is printed as it appears on the screen
            var styles = `
                <style>
                    .card-container {
                        width: 85.6mm;
                        height: 53.98mm;
                        background-color: #c79c31;
                        border-radius: 10px;
                        padding: 10px;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                        font-size: 12px;
                        color: black;
                        position: relative;
                        text-align: center;
                    }
                    .header {
                        background-color: black;
                        color: white;
                        font-weight: bold;
                        padding: 5px;
                        position: absolute;
                        top: 10px;
                        left: 50px;
                        right: 10px;
                        text-align: center;
                        border-top-left-radius: 5px;
                        border-bottom-left-radius: 5px;
                    }
                    .profile-section {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        margin-top: 40px;
                    }
                    .profile-img {
                        width: 50px;
                        height: 50px;
                        border-radius: 50%;
                        margin-bottom: 5px;
                    }
                    .profile-name {
                        font-size: 14px;
                        font-weight: bold;
                    }
                    .info-section {
                        text-align: left;
                        margin-top: 5px;
                    }
                    .info-section p {
                        font-size: 10px;
                        margin-bottom: 2px;
                    }
                    .qr-code {
                        width: 50px;
                        height: 50px;
                        position: absolute;
                        bottom: 10px;
                        right: 10px;
                    }
                    .logo {
                        width: 40px;
                        height: 40px;
                        position: absolute;
                        top: 5px;
                        left: 5px;
                    }
                    p {
                        margin-bottom: 2px;
                    }
                    @media print {
                        body {
                            -webkit-print-color-adjust: exact; /* Enable color and background graphics */
                            print-color-adjust: exact;
                        }
                    }
                </style>
            `;

            printWindow.document.write('<html><head><title>Print Card</title>' + styles + '</head><body>');
            
            // Update the QR code image to load in the print window
            var qrCodeImage = cardToPrint.querySelector('.qr-code');
            var qrCodeSrc = 'https://api.qrserver.com/v1/create-qr-code/?size=50x50&data=' + $(qrCodeImage).data('id');
            qrCodeImage.src = qrCodeSrc; // Set QR code src dynamically

            // Wait for the QR code image to load before printing
            var qrImage = new Image();
            qrImage.src = qrCodeSrc;

            qrImage.onload = function() {
                // Once the QR code is loaded, set a delay before printing
                printWindow.document.write(cardToPrint.outerHTML);
                printWindow.document.write('</body></html>');
                setTimeout(function() {
                    // After the delay, write the cloned card to the print window
                    printWindow.document.close(); // Close the document for the print to work
                    printWindow.print(); // Trigger the print dialog
                }, 1000); // 1000ms (1 second) delay
            };
        };
    });
", \yii\web\View::POS_END);
?>

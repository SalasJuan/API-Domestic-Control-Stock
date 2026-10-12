<?php 

final readonly class PurchaseDetailRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "purchaseDetail_get",
        "url" => "/purchasesDetails",
        "controller" => "PurchaseDetail/PurchaseDetailGetController.php",
        "method" => "GET",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ],
      [
        "name" => "purchaseDetail_get",
        "url" => "/purchasesDetails",
        "controller" => "PurchaseDetail/PurchaseDetailsGetController.php",
        "method" => "GET"
      ],
      [
        "name" => "purchaseDetail_post",
        "url" => "/purchasesDetails",
        "controller" => "PurchaseDetail/PurchaseDetailPostController.php",
        "method" => "POST"
      ],
      [
        "name" => "purchaseDetail_put",
        "url" => "/purchasesDetails",
        "controller" => "PurchaseDetail/PurchaseDetailPutController.php",
        "method" => "PUT",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
        ],
        [
        "name" => "purchaseDetail_delete",
        "url" => "/purchasesDetails",
        "controller" => "PurchaseDetail/PurchaseDetailDeleteController.php",
        "method" => "DELETE",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ],
      [
          "name" => "purchaseDetail_restore",
          "url" => "/purchasesDetails/restore",
          "controller" => "PurchaseDetail/PurchaseDetailRestoreController.php",
          "method" => "POST",
          "parameters" => [
              [
                  "name" => "id",
                  "type" => "int"
              ]
          ]
      ]
    ];
  }
}
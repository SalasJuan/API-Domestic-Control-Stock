<?php 

final readonly class PurchaseRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "purchase_get",
        "url" => "/purchases",
        "controller" => "Purchase/PurchaseGetController.php",
        "method" => "GET",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ],
      [
        "name" => "purchases_get",
        "url" => "/purchases",
        "controller" => "Purchase/PurchasesGetController.php",
        "method" => "GET"
      ],
      [
        "name" => "purchase_post",
        "url" => "/purchases",
        "controller" => "Purchase/PurchasePostController.php",
        "method" => "POST"
      ],
      [
        "name" => "purchase_put",
        "url" => "/purchases",
        "controller" => "Purchase/PurchasePutController.php",
        "method" => "PUT",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
        ],
        [
        "name" => "purchase_delete",
        "url" => "/purchases",
        "controller" => "Purchase/PurchaseDeleteController.php",
        "method" => "DELETE",
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
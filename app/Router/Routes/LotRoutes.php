<?php 

final readonly class LotRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "lot_get",
        "url" => "/lots",
        "controller" => "Lot/LotGetController.php",
        "method" => "GET",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ],
      [
        "name" => "lots_get",
        "url" => "/lots",
        "controller" => "Lot/LotsGetController.php",
        "method" => "GET"
      ],
      [
        "name" => "lot_post",
        "url" => "/lots",
        "controller" => "Lot/LotPostController.php",
        "method" => "POST"
      ],
      [
        "name" => "lot_put",
        "url" => "/lots",
        "controller" => "Lot/LotPutController.php",
        "method" => "PUT",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
        ],
        [
        "name" => "lot_delete",
        "url" => "/lots",
        "controller" => "Lot/LotDeleteController.php",
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
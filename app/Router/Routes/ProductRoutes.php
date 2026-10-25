<?php 

final readonly class ProductRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "product_get",
        "url" => "/products",
        "controller" => "Product/ProductGetController.php",
        "method" => "GET",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ],
      [
        "name" => "products_get",
        "url" => "/products",
        "controller" => "Product/ProductsGetController.php",
        "method" => "GET"
      ],
      [
        "name" => "products_get_StockAlert",
        "url" => "/productsStockAlert",
        "controller" => "Product/ProductsGetStockAlertController.php",
        "method" => "GET"
      ],
      [
        "name" => "product_post",
        "url" => "/products",
        "controller" => "Product/ProductPostController.php",
        "method" => "POST"
      ],
      [
        "name" => "product_put",
        "url" => "/products",
        "controller" => "Product/ProductPutController.php",
        "method" => "PUT",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
        ],
        [
        "name" => "product_delete",
        "url" => "/products",
        "controller" => "Product/ProductDeleteController.php",
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

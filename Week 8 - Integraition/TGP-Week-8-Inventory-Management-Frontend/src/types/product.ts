export interface Product {
  product_id?: number | string;
  id?: number | string;
  name: string;
  image: string;
  price?: number | string;
  total_quantity?: number | string;
}

export interface ProductSale {
  product_id: number;
  name: string;
  total_quantity: string;
  price: number;
  image: string;
}

export interface LowStockProduct {
  id: number;
  name: string;
  image: string;
}

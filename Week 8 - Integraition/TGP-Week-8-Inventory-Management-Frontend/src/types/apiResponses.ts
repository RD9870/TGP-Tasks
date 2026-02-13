import type { LowStockProduct, ProductSale } from "./product";

export interface ProductsOverviewResponse {
  "best sellers": ProductSale[];
  "worst sellers": ProductSale[];
}

export interface MonthlyRateResponse {
  month: number;
  year: number;
  total_profit: number;
}

export interface lowStockProductsResponse {
  "number-of-low-stock-items": number;
  items: LowStockProduct[];
}

export interface LoginResponse {
  access_token: string;
}

export interface UserInfoResponse {
  type: string;
}

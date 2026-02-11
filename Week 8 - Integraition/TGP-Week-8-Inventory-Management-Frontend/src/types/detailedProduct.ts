export interface DetailedProduct {
  id: number;
  code: string;
  name: string;
  subcategory_id: number;
  price: string;
  manufacture_id: number;
  import_company_id: number;
  isStockLow: boolean;
  minimum: number;
  image: string;
  quantity?: number;
  cost_price?: string;
}

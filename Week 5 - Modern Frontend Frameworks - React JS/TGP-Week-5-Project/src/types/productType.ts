// make an interface to define the structure of a product object that we will receive from the backend API to use

export interface Product {
  id: string;
  title: string;
  description: string;
  category: string;
  price: number;
  rating: number;
  stock: number;
  brand: string;
  images: string[];
  thumbnail: string;
}

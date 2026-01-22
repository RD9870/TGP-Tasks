import type { Product } from "../types/productType";
interface ProductDetailsProps {
  product: Product;
}

function ProductDetails({ product }: ProductDetailsProps) {
  return (
    <div>
      <img src={product.images[0]} />
      <h2 className="text-2xl font-bold mb-4">{product.title}</h2>
      <p className="mb-2">{product.description}</p>
      <p className="mb-2 font-semibold">Category: {product.category}</p>
      <p className="mb-2 font-semibold">Brand: {product.brand}</p>
      <p className="mb-2 font-semibold">Price: ${product.price}</p>
      <p className="mb-2 font-semibold">Stock: {product.stock}</p>
    </div>
  );
}

export default ProductDetails;

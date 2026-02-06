import type { Product } from "../types/productType";

// the product details popup component

//interface for product details props
interface ProductDetailsProps {
  product: Product;
}

function ProductDetails({ product }: ProductDetailsProps) {
  return (
    <div>
      {/* product image */}
      <img src={product.images[0]} />
      {/* product name */}
      <h2 className="text-2xl font-bold mb-4">{product.title}</h2>
      {/* a short discription for the product */}
      <p className="mb-2">{product.description}</p>
      {/* product category */}
      <p className="mb-2 font-semibold">Category: {product.category}</p>
      {/* product brand */}
      <p className="mb-2 font-semibold">Brand: {product.brand}</p>
      {/* product price */}
      <p className="mb-2 font-semibold">Price: ${product.price}</p>
      {/* product stock */}
      <p className="mb-2 font-semibold">Stock: {product.stock}</p>
    </div>
  );
}

export default ProductDetails;

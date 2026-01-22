import Btn from "../components/btn";
import ax from "../api/api";
import { useEffect, useState } from "react";
import LoadingSkeleton from "../components/loading";
import type { Product } from "../types/productType";
import ActionsBtn from "../components/actionsBtn";
import PopUpModal from "./popUpModal";
import AddProduct from "./addProduct";
import ConfirmDeletion from "../components/confirm-deletion";
import ProductDetails from "../components/productDetails";
import toast from "react-hot-toast";

function Products() {
  const [isClicked, setIsClicked] = useState<boolean>(false);
  const [products, setProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState(true);
  const [isPopUpOpen, setIsPopUpOpen] = useState<boolean>(false);
  const [selectedProduct, setSelectedProduct] = useState<Product | null>(null);
  const [isEdit, setIsEdit] = useState<boolean>(false);
  const [isDetails, setIsDetails] = useState<boolean>(false);
  const [isDelete, setIsDelete] = useState<boolean>(false);

  useEffect(() => {
    ax.get("/products?limit=15")
      .then((res) => setProducts(res.data.products))
      .catch((err) => console.error(err))
      .finally(() => setLoading(false));
  }, []);

  async function onProductDelete(product: Product) {
    setSelectedProduct(product);
    setIsPopUpOpen(true);
    setIsDelete(true);
    if (selectedProduct) {
      try {
        await ax.delete(`/products/${product.id}`);
        toast.success(`${product.title} has been deleted`);
        setSelectedProduct(null);
        setIsPopUpOpen(false);
      } catch (err) {
        toast.error("Something went wrong try again");
        console.error("Error deleting product", err);
      }
    }
  }

  function onProductEdit(product: Product) {
    setSelectedProduct(product);
    setIsPopUpOpen(true);
    setIsEdit(true);
  }

  return loading ? (
    <div className="w-full h-screen bg-gray-100 p-4">
      <LoadingSkeleton />
    </div>
  ) : (
    <>
      <div className="bg-white m-5">
        <div className=" flex p-5 justify-end w-full">
          <Btn
            label="add product"
            color="bg-primary-btn"
            whenClicked={async () => {
              setIsClicked(true);
              setIsPopUpOpen(true);
            }}
            disable={isClicked}
          />
        </div>

        <div className="p-6">
          <table className=" w-full border-collapse p-5">
            <thead className="bg-table-header sticky top-0 z-20">
              <tr>
                <th className="th-style">ID</th>
                <th className="th-style">Product Name</th>
                <th className="th-style">description</th>
                <th className="th-style">category</th>
                <th className="th-style">price</th>
                <th className="th-style">rating</th>
                <th className="th-style">stock</th>
                <th className="th-style">brand</th>
                <th className="th-style">Action</th>
              </tr>
            </thead>
            <tbody>
              {products.map((prod) => (
                <tr key={prod.id}>
                  <td className="td-style">{prod.id}</td>
                  <td className="td-style">
                    <button
                      onClick={() => {
                        setSelectedProduct(prod);
                        setIsDetails(true);
                        setIsPopUpOpen(true);
                      }}
                      className="flex flex-col md:flex-row text-center items-center justify-start gap-2"
                    >
                      <img
                        src={prod.thumbnail}
                        alt={prod.title}
                        className="w-20 h-20 object-cover mb-1 rounded"
                      />
                      <span className="text-wrap text-center">
                        {prod.title}
                      </span>
                    </button>
                  </td>
                  <td className="td-style">
                    <div className="line-clamp-3 max-w-xs whitespace-normal">
                      {prod.description}
                    </div>
                  </td>
                  <td className="td-style">{prod.category}</td>
                  <td className="td-style">{prod.price}</td>
                  <td className="td-style">{prod.rating}</td>
                  <td className="td-style">{prod.stock}</td>
                  <td className="td-style">{prod.brand}</td>
                  <td className="td-style">
                    <ActionsBtn
                      onDelete={() => onProductDelete(prod)}
                      onEdit={() => onProductEdit(prod)}
                    />
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      <PopUpModal
        isOpen={isPopUpOpen}
        onClose={() => {
          setIsClicked(false);
          setIsPopUpOpen(false);
          setSelectedProduct(null);
          setIsEdit(false);
          setIsDetails(false);
        }}
      >
        {isDetails && selectedProduct ? (
          <ProductDetails product={selectedProduct} />
        ) : isEdit && selectedProduct ? (
          <AddProduct
            productToEdit={selectedProduct}
            onSuccess={() => {
              setIsPopUpOpen(false);
              setSelectedProduct(null);
              setIsEdit(false);
            }}
          />
        ) : selectedProduct && isDelete ? (
          <ConfirmDeletion
            Product={selectedProduct}
            onCancel={() => {
              setIsPopUpOpen(false);
              setSelectedProduct(null);
            }}
            onDelete={() => onProductDelete(selectedProduct)}
          />
        ) : (
          <AddProduct
            onSuccess={() => {
              setIsPopUpOpen(false);
            }}
          />
        )}
      </PopUpModal>
    </>
  );
}

export default Products;

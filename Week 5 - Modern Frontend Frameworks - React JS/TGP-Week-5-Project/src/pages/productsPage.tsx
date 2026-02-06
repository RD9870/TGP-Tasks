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
  // state hook to manage the add product popup
  const [isClicked, setIsClicked] = useState<boolean>(false);

  // state hook to store the list of products fetched from the backend
  const [products, setProducts] = useState<Product[]>([]);

  // state hook to manage the loading state
  const [loading, setLoading] = useState(true);

  // state hook to amange the product details popup
  const [isPopUpOpen, setIsPopUpOpen] = useState<boolean>(false);

  // state hook to store the product that is selected for viewing details, editing, or deleting
  const [selectedProduct, setSelectedProduct] = useState<Product | null>(null);

  // state hooks to determine the type of action the user wants to perform on the selected product (view details, edit, or delete)
  const [isEdit, setIsEdit] = useState<boolean>(false);
  const [isDetails, setIsDetails] = useState<boolean>(false);
  const [isDelete, setIsDelete] = useState<boolean>(false);

  useEffect(() => {
    // get the products from the backend
    ax.get("/products?limit=15")
      // add them to the products state
      .then((res) => setProducts(res.data.products))
      // print any error in the console
      .catch((err) => console.error(err))
      // remove the loading skeleton
      .finally(() => setLoading(false));
  }, []);

  // delete the selected product
  async function onProductDelete(product: Product) {
    // set the selected product
    setSelectedProduct(product);
    // open the confirmation popup
    setIsPopUpOpen(true);
    // set the deleted state
    setIsDelete(true);
    if (selectedProduct) {
      try {
        // send the delete request tot the api
        await ax.delete(`/products/${product.id}`);
        // show user feedback
        toast.success(`${product.title} has been deleted`);
        // reset the selected product and close the popup
        setSelectedProduct(null);
        setIsPopUpOpen(false);
      } catch (err) {
        // print the error and show feedback to the user
        toast.error("Something went wrong try again");
        console.error("Error deleting product", err);
      } finally {
        setIsDelete(false);
      }
    }
  }

  // the rest of the logic is in the edi popup component
  function onProductEdit(product: Product) {
    setSelectedProduct(product);
    setIsPopUpOpen(true);
    setIsEdit(true);
  }

  // if the products are still being fetched show sceletons
  return loading ? (
    <div className="w-full h-screen bg-gray-100 p-4">
      <LoadingSkeleton />
    </div>
  ) : (
    <>
      <div className="bg-white m-5">
        <div className=" flex p-5 justify-end w-full">
          {/* add product button */}
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

        {/* products table */}
        <div className="p-6">
          <table className=" w-full border-collapse p-5">
            {/* table titles */}
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

            {/* products */}
            <tbody>
              {products.map((prod) => (
                <tr key={prod.id}>
                  {/* id */}
                  <td className="td-style">{prod.id}</td>

                  {/* name and image */}
                  <td className="td-style">
                    {/* image as a button to show details pop up */}
                    <button
                      onClick={() => {
                        setSelectedProduct(prod);
                        setIsDetails(true);
                        setIsPopUpOpen(true);
                      }}
                      className="flex flex-col md:flex-row text-center items-center justify-start gap-2"
                    >
                      {/* image */}
                      <img
                        src={prod.thumbnail}
                        alt={prod.title}
                        className="w-20 h-20 object-cover mb-1 rounded"
                      />

                      {/* name */}
                      <span className="text-wrap text-center">
                        {prod.title}
                      </span>
                    </button>
                  </td>

                  {/* products details */}
                  <td className="td-style">
                    <div className="line-clamp-3 max-w-xs whitespace-normal">
                      {prod.description}
                    </div>
                  </td>
                  {/* category */}
                  <td className="td-style">{prod.category}</td>

                  {/* price */}
                  <td className="td-style">{prod.price}</td>

                  {/* rating */}
                  <td className="td-style">{prod.rating}</td>

                  {/*  stock */}
                  <td className="td-style">{prod.stock}</td>

                  {/* brand */}
                  <td className="td-style">{prod.brand}</td>

                  {/* actions button to edit and delete */}
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

      {/* popup model */}
      <PopUpModal
        isOpen={isPopUpOpen}
        // close the pop function to reset all states
        onClose={() => {
          setIsClicked(false);
          setIsPopUpOpen(false);
          setSelectedProduct(null);
          setIsEdit(false);
          setIsDetails(false);
        }}
      >
        {/* show the details popup */}
        {isDetails && selectedProduct ? (
          <ProductDetails product={selectedProduct} />
        ) : // show the edit popup
        isEdit && selectedProduct ? (
          <AddProduct
            productToEdit={selectedProduct}
            // reset the states and close the popup
            onSuccess={() => {
              setIsPopUpOpen(false);
              setSelectedProduct(null);
              setIsEdit(false);
            }}
          />
        ) : // show the delete confirmation popup
        selectedProduct && isDelete ? (
          <ConfirmDeletion
            Product={selectedProduct}
            // user cacel deletion so reset the states and close the popup
            onCancel={() => {
              setIsPopUpOpen(false);
              setSelectedProduct(null);
              setIsDelete(false);
            }}
            // call the delete function
            onDelete={() => onProductDelete(selectedProduct)}
          />
        ) : (
          // show the add product popup
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

import Btn from "../components/btn";
import ax from "../api/api";
import { useEffect, useState } from "react";
import LoadingSkeleton from "../components/loading";
import type { Product } from "../types/productType";
import toast from "react-hot-toast";

function OutOfStock() {
  // list of products that are out of stock
  const [products, setProducts] = useState<Product[]>([]);

  // loading state
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // get the products from the backend
    ax.get("/products?sortBy=stock&order=asc&limit=15")
      // add them to the products state
      .then((res) => setProducts(res.data.products))
      // print any error in the console
      .catch((err) => console.error(err))
      // remove the loading skeleton
      .finally(() => setLoading(false));
  }, []);

  return loading ? (
    // show loading skeleton while the products are being fetched from the backend
    <div className="w-full h-screen bg-gray-100 p-4">
      <LoadingSkeleton />
    </div>
  ) : (
    <>
      {/* show the products in a table */}
      <div className="bg-white m-5">
        <div className="p-6">
          <table className=" w-full border-collapse p-5">
            <thead className="bg-table-header sticky top-0">
              <tr>
                {/* headers with names */}
                <th className="th-style">ID</th>
                <th className="th-style">Product Name</th>
                <th className="th-style">category</th>
                <th className="th-style">stock</th>
                <th className="th-style">Action</th>
              </tr>
            </thead>
            <tbody>
              {products.map((prod) => (
                // id
                <tr key={prod.id}>
                  {/* id */}
                  <td className="td-style">{prod.id}</td>
                  {/* name and image */}
                  <td className="td-style">
                    <div className="flex flex-col md:flex-row text-center items-center justify-start gap-2">
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
                    </div>
                  </td>

                  {/* category */}
                  <td className="td-style">{prod.category}</td>

                  {/* stock */}
                  <td className="td-style">{prod.stock}</td>

                  {/* oreder now button */}
                  <td className="td-style">
                    <Btn
                      color="bg-primary-btn"
                      label="Order Now"
                      disable={false}
                      whenClicked={() => {
                        toast.success("New Order Was Placed");
                      }}
                    />
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </>
  );
}

export default OutOfStock;

import Btn from "../components/btn";
import ax from "../api/api";
import { useEffect, useState } from "react";
import LoadingSkeleton from "../components/loading";
import type { Product } from "../types/productType";
import toast from "react-hot-toast";

function OutOfStock() {
  const [products, setProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    ax.get("/products?sortBy=stock&order=asc&limit=15")
      .then((res) => setProducts(res.data.products))
      .catch((err) => console.error(err))
      .finally(() => setLoading(false));
  }, []);

  return loading ? (
    <div className="w-full h-screen bg-gray-100 p-4">
      <LoadingSkeleton />
    </div>
  ) : (
    <>
      <div className="bg-white m-5">
        <div className="p-6">
          <table className=" w-full border-collapse p-5">
            <thead className="bg-table-header sticky top-0">
              <tr>
                <th className="th-style">ID</th>
                <th className="th-style">Product Name</th>
                <th className="th-style">category</th>
                <th className="th-style">stock</th>
                <th className="th-style">Action</th>
              </tr>
            </thead>
            <tbody>
              {products.map((prod) => (
                <tr key={prod.id}>
                  <td className="td-style">{prod.id}</td>
                  <td className="td-style">
                    <div className="flex flex-col md:flex-row text-center items-center justify-start gap-2">
                      <img
                        src={prod.thumbnail}
                        alt={prod.title}
                        className="w-20 h-20 object-cover mb-1 rounded"
                      />
                      <span className="text-wrap text-center">
                        {prod.title}
                      </span>
                    </div>
                  </td>
                  <td className="td-style">{prod.category}</td>
                  <td className="td-style">{prod.stock}</td>
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

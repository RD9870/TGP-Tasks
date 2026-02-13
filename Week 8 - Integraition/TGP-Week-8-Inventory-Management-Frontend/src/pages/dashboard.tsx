import { ThumbsDown, ShoppingCart, TrendingUp, Medal } from "lucide-react";
import MetricCard from "../components/ui/MetricCard";
import api from "../api";
import { useEffect, useState } from "react";
import ProductsDetailsSection from "../components/dashboard/top_5_section";
import { useNavigate } from "react-router-dom";
import type {
  lowStockProductsResponse,
  MonthlyRateResponse,
  ProductsOverviewResponse,
} from "../types/apiResponses";
import toast from "react-hot-toast";

function Dashboard() {
  // navigation
  const navigate = useNavigate();
  // user type for the profile portion
  const userType = localStorage.getItem("user_type");
  // products lists
  const [worstAndBestSellers, setworstAndBestSellers] =
    useState<ProductsOverviewResponse | null>(null);
  const [MonthlyProfit, setMonthlyProfit] =
    useState<MonthlyRateResponse | null>(null);
  const [lowStockProducts, setLowStockProducts] =
    useState<lowStockProductsResponse | null>(null);
  // loading indicator
  const [loading, setLoading] = useState(true);
  // open model variables
  const [showTopProducts, setShowTopProducts] = useState(false);
  const [showWorstProducts, setShowWorstProducts] = useState(false);
  const [showLowStockProducts, setShowLowStockProducts] = useState(false);

  // get data from the backend
  const getStackedData = async () => {
    try {
      // show loadinf indicator
      setLoading(true);
      const [ovRes, profitRes, stockRes] = await Promise.all([
        api.get<ProductsOverviewResponse>("/products/overview/5"),
        api.get<MonthlyRateResponse>("/monthly-rate"),
        api.get<lowStockProductsResponse>("/lowStockCount"),
      ]);
      // set tghe retrived values
      setworstAndBestSellers(ovRes.data);
      setMonthlyProfit(profitRes.data);
      setLowStockProducts(stockRes.data);
    } catch (err: any) {
      //catch error and show it in the console and ui
      console.error("Error fetching data", err);
      toast.error("Error fetching data");
    } finally {
      // remove loading indicator
      setLoading(false);
    }
  };

  // get the data once after the ui is rendered
  useEffect(() => {
    getStackedData();
  }, []);

  return (
    <div className="min-h-screen bg-[#0f172a] p-4 md:p-8 font-sans text-slate-100">
      {/* title and subtitle */}
      <div className="max-w-7xl mx-auto mb-10">
        <h1 className="text-3xl font-extrabold text-white">
          Dashboard Overview
        </h1>
        <p className="text-slate-400 mt-2">
          Monitor your business performance.
        </p>
      </div>

      {/* cards */}
      <div className="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {/* best seller cards */}
        <MetricCard
          title="Best seller"
          value={
            loading
              ? "Loading..."
              : worstAndBestSellers?.["best sellers"]?.[0]?.name || "N/A"
          }
          icon={
            <Medal
              size={26}
              className={
                showTopProducts
                  ? "text-yellow-400 fill-yellow-400/20"
                  : "text-yellow-500/70"
              }
            />
          }
          onClick={() => {
            setShowTopProducts(!showTopProducts);
            setShowWorstProducts(false);
            setShowLowStockProducts(false);
          }}
        />

        {/* worst sellers card */}
        <MetricCard
          title="Worst seller"
          value={
            loading
              ? "Loading..."
              : worstAndBestSellers?.["worst sellers"]?.[0]?.name || "N/A"
          }
          icon={
            <ThumbsDown
              size={26}
              className={
                showWorstProducts
                  ? "text-rose-500 fill-rose-500/20"
                  : "text-rose-500/70"
              }
            />
          }
          onClick={() => {
            setShowWorstProducts(!showWorstProducts);
            setShowTopProducts(false);
            setShowLowStockProducts(false);
          }}
        />

        {/* low stock card */}
        <MetricCard
          title="Low stock items"
          value={
            loading
              ? "..."
              : lowStockProducts?.["number-of-low-stock-items"] || 0
          }
          icon={
            <ShoppingCart
              size={26}
              className={
                showLowStockProducts
                  ? "text-orange-500 fill-orange-500/20"
                  : "text-orange-500/70"
              }
            />
          }
          onClick={() => {
            setShowLowStockProducts(!showLowStockProducts);
            setShowWorstProducts(false);
            setShowTopProducts(false);
          }}
        />

        {/* profits */}
        <MetricCard
          title="Monthly Profit"
          value={
            loading
              ? "..."
              : `$${MonthlyProfit?.total_profit?.toLocaleString() || 0}`
          }
          icon={<TrendingUp size={26} className="text-emerald-400" />}
          onClick={
            userType === "admin" ? () => navigate("/profitDetails") : undefined
          }
        />
      </div>

      {/* best sellers */}
      <div className="max-w-7xl mx-auto mt-10 space-y-6">
        {showTopProducts && worstAndBestSellers?.["best sellers"] && (
          <div className="animate-in fade-in slide-in-from-bottom-4 duration-300">
            <ProductsDetailsSection
              type="best"
              products={worstAndBestSellers["best sellers"]}
              onClose={() => setShowTopProducts(false)}
            />
          </div>
        )}

        {/* worst sellers */}
        {showWorstProducts && worstAndBestSellers?.["worst sellers"] && (
          <div className="animate-in fade-in slide-in-from-bottom-4 duration-300">
            <ProductsDetailsSection
              type="worst"
              products={worstAndBestSellers["worst sellers"]}
              onClose={() => setShowWorstProducts(false)}
            />
          </div>
        )}

        {/* low stock */}
        {showLowStockProducts && lowStockProducts?.items && (
          <div className="animate-in fade-in slide-in-from-bottom-4 duration-300">
            <ProductsDetailsSection
              type="low-stock"
              products={lowStockProducts.items}
              onClose={() => setShowLowStockProducts(false)}
            />
          </div>
        )}
      </div>
    </div>
  );
}

export default Dashboard;

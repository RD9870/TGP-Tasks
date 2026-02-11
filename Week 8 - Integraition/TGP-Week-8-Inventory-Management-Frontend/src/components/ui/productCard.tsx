import { TriangleAlert, Pencil, Trash2 } from "lucide-react";

// define product card props
interface ProductCardProps {
  id: number | string;
  name: string;
  price: string | number;
  image: string;
  isStockLow: boolean;
  onEdit: () => void;
  onDelete: () => void;
}

function ProductCard({
  name,
  price,
  image,
  isStockLow,
  onEdit,
  onDelete,
}: ProductCardProps) {
  return (
    <div className="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden hover:border-blue-500/40 transition-all shadow-lg group">
      {/* product image */}
      <div className="relative h-48">
        <img
          src={
            image || "https://placehold.co/400x300/1e293b/white?text=No+Image"
          }
          className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          alt={name}
        />

        {/* low stock alert baner */}
        {isStockLow ? (
          <div className="absolute top-3 left-3">
            <span className="bg-orange-500/20 border border-orange-500/30 backdrop-blur-md text-orange-400 px-3 py-1 rounded-full text-[10px] font-bold flex items-center gap-1 uppercase">
              <TriangleAlert size={12} /> Low Stock
            </span>
          </div>
        ) : null}
      </div>

      {/* product name */}
      <div className="p-5">
        <h3 className="text-white font-semibold text-lg truncate mb-1">
          {name}
        </h3>

        {/* product price */}
        <div className="flex items-center justify-between border-t border-zinc-800/50 pt-4">
          <div className="flex flex-col">
            <span className="text-2xl font-bold text-white">${price}</span>
          </div>

          {/* action icons */}
          {localStorage.getItem("user_type") == "admin" ? (
            //if user is an admin they can edit or delete the product
            <div className="flex items-center gap-2">
              {/* edit btn */}
              <button
                type="button"
                onClick={(e) => {
                  e.preventDefault();
                  e.stopPropagation(); // prevent multiple clicks
                  onEdit();
                }}
                className="p-2.5 bg-blue-600/10 hover:bg-blue-600 text-blue-500 hover:text-white rounded-xl transition-all active:scale-90"
                title="Edit"
              >
                <Pencil size={18} />
              </button>

              {/* delete btn */}
              <button
                type="button"
                onClick={(e) => {
                  e.preventDefault();
                  e.stopPropagation(); // prevent multiple clicks
                  onDelete();
                }}
                className="p-2.5 bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white rounded-xl transition-all active:scale-90"
                title="Delete"
              >
                <Trash2 size={18} />
              </button>
            </div>
          ) : null}
        </div>
      </div>
    </div>
  );
}

export default ProductCard;

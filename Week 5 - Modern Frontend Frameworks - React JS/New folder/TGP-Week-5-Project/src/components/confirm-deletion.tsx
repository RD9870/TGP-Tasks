import type { Product } from "../types/productType";

// a confirm the deleteion popup component

// interface to define the props for ConfirmDeletion component
interface ConfirmDeletionProps {
  Product: Product;
  onCancel: () => void;
  onDelete: () => void;
}

function ConfirmDeletion({
  Product,
  onCancel,
  onDelete,
}: ConfirmDeletionProps) {
  return (
    <div>
      {/* pop up title and subtitles */}
      <h2 className="text-xl font-semibold mb-4">Confirm Deletion</h2>
      <p className="mb-6">Are you sure you want to delete this product?</p>
      <p>{Product.title}</p>
      <p>This action cannot be undone.</p>

      {/* list of actions buttons */}
      <div className="flex justify-end gap-4">
        {/* cancel button */}
        <button
          className="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
          onClick={onCancel}
        >
          Cancel
        </button>

        {/* delete button */}
        <button
          className="px-4 py-2 bg-primary-btn text-white rounded hover:bg-orange-700"
          onClick={onDelete}
        >
          Delete
        </button>
      </div>
    </div>
  );
}

export default ConfirmDeletion;

import { Layers, X } from "lucide-react";
import type { Category } from "../types/category";
import toast from "react-hot-toast";
import { useEffect, useState } from "react";
import api from "../api";
import { Modal, ModalBody, ModalHeader } from "flowbite-react";

interface CategoryModalProps {
  isOpen: boolean;
  // isAdmin: boolean;
  catBaseUrl: string;
  //   currentCat: Category | null;
  onClose: () => void;
  editingCategory: Category | null;
}

function CategoryModal({
  isOpen,
  // isAdmin,
  catBaseUrl,
  //   currentCat,
  onClose,
  editingCategory,
}: CategoryModalProps) {
  // const catBaseUrl = isAdmin ? "/categories" : "/categoriesm";
  const [catForm, setCatForm] = useState({ name: "" });
  //   const [currentCat, setCurrentCat] = useState<Category | null>(null);
  const [loading, setLoading] = useState(true);
  const [categories, setCategories] = useState<Category[]>([]);

  useEffect(() => {
    if (isOpen) {
      const fetchData = async () => {
        try {
          setLoading(true);
          const [catRes] = await Promise.all([api.get<Category[]>(catBaseUrl)]);
          setCategories(catRes.data);
        } catch (err) {
          toast.error("Error loading data");
        } finally {
          setLoading(false);
        }
      };
      fetchData();
    }
  }, [isOpen]);

  useEffect(() => {
    if (editingCategory) {
      setCatForm({
        name: editingCategory.name,
      });
    }
    // if moadel is opened in adding mode initialize the form to empty values
    // this reset the values if the user edits then adds something
    else {
      setCatForm({
        name: "",
      });
    }
  }, [editingCategory, isOpen]);

  const handleCatSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    const tid = toast.loading("Saving category...");
    try {
      setLoading(true);
      if (editingCategory?.id) {
        const response = await api.put(
          `${catBaseUrl}/${editingCategory.id}`,
          catForm,
        );
        console.log("response:", response.data);
        toast.success("Category updated", { id: tid });
      } else {
        await api.post(catBaseUrl, catForm);
        toast.success("Category created", { id: tid });
      }
      onClose();
    } catch (err: any) {
      toast.error("Action failed", { id: tid });
    } finally {
      setLoading(false);
    }
  };

  // model
  return (
    <>
      <Modal show={isOpen} onClose={onClose} size="lg">
        {/* title add or edit */}
        <ModalHeader className="bg-slate-900 border-slate-800">
          <span className="text-white">
            {editingCategory ? "Edit Category" : "Add New Category"}
          </span>
        </ModalHeader>

        {/* form */}
        <ModalBody className="bg-slate-900">
          <div className="fixed inset-0 bg-slate-950/80 backdrop-blur-md flex justify-center items-center p-4 z-50 animate-in fade-in duration-200">
            <div className="bg-slate-900 border border-slate-800 rounded-3xl w-full max-w-md shadow-2xl overflow-hidden">
              <div className="p-6 border-b border-slate-800 flex justify-between items-center bg-slate-900/50">
                <h2 className="text-xl font-bold flex items-center gap-2 text-white">
                  <Layers className="text-indigo-500" />{" "}
                  {editingCategory ? "Edit Category" : "New Category"}
                </h2>
                <button
                  onClick={() => onClose()}
                  className="text-slate-500 hover:text-white transition-colors"
                >
                  <X size={24} />
                </button>
              </div>
              <form
                onSubmit={loading ? undefined : handleCatSubmit}
                className="p-8 space-y-6"
              >
                <div className="space-y-2">
                  <label className="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">
                    Category Name
                  </label>
                  <input
                    className="w-full bg-slate-800/50 border border-slate-700 text-white rounded-xl p-3 outline-none focus:ring-2 focus:ring-indigo-500/50"
                    value={catForm.name}
                    onChange={(e) => setCatForm({ name: e.target.value })}
                    placeholder="e.g. Electronics"
                    required
                  />
                </div>
                <button className="w-full bg-indigo-600 py-4 rounded-xl font-black text-sm tracking-widest hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-600/20">
                  {loading ? "Saving...." : "SAVE CATEGORY"}
                </button>
              </form>
            </div>
          </div>
        </ModalBody>
      </Modal>
    </>
  );
}

export default CategoryModal;

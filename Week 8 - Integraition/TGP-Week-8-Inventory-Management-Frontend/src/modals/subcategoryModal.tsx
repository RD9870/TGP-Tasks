import { Layers, X } from "lucide-react";
import type { Category } from "../types/category";
import toast from "react-hot-toast";
import { useEffect, useState } from "react";
import api from "../api";
import { Modal, ModalBody, ModalHeader } from "flowbite-react";
import type { Subcategory } from "../types/subcategory";

interface SubcategoryModalProps {
  isOpen: boolean;
  // isAdmin: boolean;
  subBaseUrl: string;
  //   currentCat: Category | null;
  categoryId: number;
  onClose: () => void;
  editingSubcategory: Subcategory | null;
}

function SubcategoryModal({
  isOpen,
  // isAdmin,
  subBaseUrl,
  //   currentCat,
  categoryId,
  onClose,
  editingSubcategory,
}: SubcategoryModalProps) {
  // const subBaseUrl = isAdmin ? "/subcategories" : "/subcategoriesm";
  const [subForm, setSubForm] = useState({ name: "", category_id: 0 });
  //   const [currentCat, setCurrentCat] = useState<Category | null>(null);
  const [loading, setLoading] = useState(true);
  // const [categories, setCategories] = useState<Category[]>([]);

  useEffect(() => {
    if (isOpen) {
      const fetchData = async () => {
        try {
          setLoading(true);
          // const [subRes] = await Promise.all([api.get<Category[]>(subBaseUrl)]);
          // setCategories(subRes.data);
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
    if (editingSubcategory) {
      setSubForm({
        name: editingSubcategory.name,
        category_id: editingSubcategory.category_id,
      });
    }
    // if moadel is opened in adding mode initialize the form to empty values
    // this reset the values if the user edits then adds something
    else {
      setSubForm({
        name: "",
        category_id: categoryId,
      });
    }
  }, [editingSubcategory, isOpen]);

  const handleSubSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    const tid = toast.loading("Saving subcategory...");
    try {
      setLoading(true);
      if (editingSubcategory?.id) {
        await api.put(`${subBaseUrl}/${editingSubcategory.id}`, subForm);
        toast.success("Subcategory updated", { id: tid });
      } else {
        await api.post(subBaseUrl, subForm);
        toast.success("Subcategory created", { id: tid });
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
            {editingSubcategory ? "Edit Subcategory" : "Add New Subcategory"}
          </span>
        </ModalHeader>

        {/* form */}
        <ModalBody className="bg-slate-900">
          <div className="fixed inset-0 bg-slate-950/80 backdrop-blur-md flex justify-center items-center p-4 z-50 animate-in fade-in duration-200">
            <div className="bg-slate-900 border border-slate-800 rounded-3xl w-full max-w-md shadow-2xl overflow-hidden">
              <div className="p-6 border-b border-slate-800 flex justify-between items-center bg-slate-900/50">
                <h2 className="text-xl font-bold flex items-center gap-2 text-white">
                  <Layers className="text-indigo-500" />{" "}
                  {editingSubcategory ? "Edit Subcategory" : "New Subcategory"}
                </h2>
                <button
                  onClick={() => onClose()}
                  className="text-slate-500 hover:text-white transition-colors"
                >
                  <X size={24} />
                </button>
              </div>
              <form
                onSubmit={loading ? undefined : handleSubSubmit}
                className="p-8 space-y-6"
              >
                <div className="space-y-2">
                  <label className="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">
                    Subcategory Name
                  </label>
                  <input
                    className="w-full bg-slate-800/50 border border-slate-700 text-white rounded-xl p-3 outline-none focus:ring-2 focus:ring-indigo-500/50"
                    value={subForm.name}
                    onChange={(e) =>
                      setSubForm({
                        name: e.target.value,
                        category_id: categoryId || 0,
                      })
                    }
                    placeholder="e.g. Electronics"
                    required
                  />
                </div>
                <button className="w-full bg-indigo-600 py-4 rounded-xl font-black text-sm tracking-widest hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-600/20">
                  {loading ? "Saving...." : "SAVE Subcategory"}
                </button>
              </form>
            </div>
          </div>
        </ModalBody>
      </Modal>
    </>
  );
}

export default SubcategoryModal;

import React, { useEffect, useState } from "react";
import {
  Pencil,
  Trash2,
  Plus,
  Layers,
  Tag,
  ChevronDown,
  ChevronRight,
  FolderPlus,
} from "lucide-react";
import api from "../api";
import toast from "react-hot-toast";
import type { Category } from "../types/category";
import type { Subcategory } from "../types/subcategory";
import CategoryModal from "../modals/categoryModal";
import SubcategoryModal from "../modals/subcategoryModal";
import ConfirmDeletionModal from "../modals/confirmDeletionModal";

function CategoriesPage() {
  // get user type
  const userType = localStorage.getItem("user_type");
  // check if the user is an admin
  const isAdmin = userType === "admin";
  // initialize the correxct urls
  const catBaseUrl = isAdmin ? "/categories" : "/categoriesm";
  const subBaseUrl = isAdmin ? "/subcategories" : "/subcategoriesm";
  // initialize the category list
  const [categories, setCategories] = useState<Category[]>([]);
  // initialize the subcategory list
  const [subCategories, setSubCategories] = useState<Subcategory[]>([]);
  // initialize the loading indicator
  const [loading, setLoading] = useState(true);
  //which cat is beign expanded
  const [expandedId, setExpandedId] = useState<number | null>(null);
  // open models tracker
  const [isCatModalOpen, setIsCatModalOpen] = useState(false);
  const [isSubModalOpen, setIsSubModalOpen] = useState(false);
  const [isDeleteModalOpen, setIsDeleteModalOpen] = useState(false);
  // track the the category/subcategory being worked on currently
  const [currentCat, setCurrentCat] = useState<Category | null>(null);
  const [currentSub, setCurrentSub] = useState<Subcategory | null>(null);
  const [deleteTarget, setDeleteTarget] = useState<{
    id: number;
    type: "cat" | "sub";
  } | null>(null);
  // thr category id of the current subcategory
  const [subcatCategory_id, setSubcatCategory_id] = useState(0);

  // get categories and subcategories from the backend
  const fetchData = async () => {
    try {
      // show lodaing indicstpr
      setLoading(true);
      // call the backend
      const [catRes, subRes] = await Promise.all([
        api.get<Category[]>(catBaseUrl),
        api.get<Subcategory[]>(subBaseUrl),
      ]);
      // add the response to the list to show in the ui
      setCategories(catRes.data);
      setSubCategories(subRes.data);
    } catch (err) {
      // show errors in the console and show user a message
      console.log(err);
      toast.error("Error loading data");
    } finally {
      // remove the lodaing indicator
      setLoading(false);
    }
  };

  // fetch the data after initial render
  useEffect(() => {
    fetchData();
  }, []);

  // openining category model for editind or adding
  const openCatModal = (cat: Category | null = null) => {
    if (!isAdmin && cat !== null) return;
    setCurrentCat(cat);
    setIsCatModalOpen(true);
  };

  // openining subcategory model for editind or adding
  const openSubModal = (sub: Subcategory | null = null, catId?: number) => {
    if (!isAdmin && sub !== null) return;
    setCurrentSub(sub);
    setSubcatCategory_id(catId || sub?.category_id || 0);
    setIsSubModalOpen(true);
  };

  // openining a model to confirm the deletion of a category or subcategory
  const confirmDelete = (id: number, type: "cat" | "sub") => {
    if (!isAdmin) return;
    setDeleteTarget({ id, type });
    setIsDeleteModalOpen(true);
  };

  // page ui
  return (
    <div className="min-h-screen bg-[#0f172a] p-4 md:p-8 font-sans text-slate-100">
      <div className="max-w-4xl mx-auto mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        {/* header title */}
        <div>
          <h1 className="text-3xl font-extrabold text-white">Categories</h1>
          <p className="text-slate-400">
            Organize your products into main and sub-categories.
          </p>
        </div>

        {/* add category btn */}
        <button
          onClick={() => openCatModal()}
          className="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-indigo-600/20 active:scale-95 transition-all"
        >
          <Plus size={20} /> New Category
        </button>
      </div>

      {/* category table */}
      <div className="max-w-4xl mx-auto bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden shadow-2xl">
        <table className="w-full text-left">
          {/* header row */}
          <thead>
            <tr className="bg-slate-800/50 text-slate-400 text-xs uppercase tracking-widest">
              <th className="p-5 w-12"></th>
              <th className="p-5">Category Name</th>
              <th className="p-5">Sub-items</th>
              <th className="p-5 text-center">Actions</th>
            </tr>
          </thead>

          {/* body */}
          <tbody className="divide-y divide-slate-800">
            {/* loading indicator */}
            {loading ? (
              <tr>
                <td colSpan={4} className="p-10 text-center animate-pulse">
                  Loading categories...
                </td>
              </tr>
            ) : (
              categories.map((cat) => (
                <React.Fragment key={cat.id}>
                  {/* category row */}
                  <tr
                    className={`hover:bg-slate-800/30 transition-all ${
                      expandedId === cat.id ? "bg-indigo-500/5" : ""
                    }`}
                  >
                    {/* category data aka name and dropdown icons */}
                    <td className="p-5">
                      {/* drop down btn */}
                      <button
                        onClick={() =>
                          setExpandedId(expandedId === cat.id ? null : cat.id!)
                        }
                        className="text-slate-500 hover:text-indigo-400"
                      >
                        {expandedId === cat.id ? (
                          <ChevronDown size={20} />
                        ) : (
                          <ChevronRight size={20} />
                        )}
                      </button>
                    </td>

                    {/* name */}
                    <td className="p-5 font-bold text-slate-200 flex items-center gap-3">
                      <Layers size={18} className="text-indigo-500" />{" "}
                      {cat.name}
                    </td>

                    {/* number of subcats */}
                    <td className="p-5 text-slate-500 text-sm">
                      {
                        subCategories.filter((s) => s.category_id === cat.id)
                          .length
                      }{" "}
                      Subcategories
                    </td>

                    {/* action icons */}
                    <td className="p-5 flex justify-center gap-3">
                      {/* add a subcategory */}
                      <button
                        onClick={() => openSubModal(null, cat.id)}
                        title="Add Subcategory"
                        className="p-2 text-indigo-400 hover:bg-indigo-500/10 rounded-lg"
                      >
                        <FolderPlus size={18} />
                      </button>

                      {/* for admin show the edit and delete btns */}
                      {isAdmin && (
                        <>
                          {/* edit btn */}
                          <button
                            onClick={() => openCatModal(cat)}
                            className="p-2 text-slate-400 hover:text-white"
                          >
                            <Pencil size={18} />
                          </button>

                          {/* delete btn */}
                          <button
                            onClick={() => confirmDelete(cat.id!, "cat")}
                            className="p-2 text-slate-400 hover:text-rose-500"
                          >
                            <Trash2 size={18} />
                          </button>
                        </>
                      )}
                    </td>
                  </tr>

                  {/* message if a category is empty */}
                  {expandedId === cat.id && (
                    <tr className="bg-slate-950/50">
                      <td colSpan={4} className="p-0">
                        <div className="px-16 py-4 space-y-2 border-l-4 border-indigo-600/30 ml-8 my-2">
                          {subCategories.filter((s) => s.category_id === cat.id)
                            .length === 0 ? (
                            <p className="text-slate-600 text-sm italic">
                              No subcategories yet.
                            </p>
                          ) : (
                            // list of the subcategories under the expanded one
                            subCategories
                              .filter((s) => s.category_id === cat.id)
                              .map((sub) => (
                                <div
                                  key={sub.id}
                                  className="flex items-center justify-between bg-slate-800/40 p-3 rounded-xl border border-slate-800/50"
                                >
                                  {/* icon */}
                                  <span className="text-slate-300 flex items-center gap-2">
                                    <Tag size={14} className="text-slate-500" />{" "}
                                    {sub.name}
                                  </span>
                                  {/* acrion btns for admin */}
                                  {isAdmin && (
                                    <div className="flex gap-2">
                                      {/* edit btn */}
                                      <button
                                        onClick={() => openSubModal(sub)}
                                        className="p-1.5 text-slate-500 hover:text-white"
                                      >
                                        <Pencil size={14} />
                                      </button>

                                      {/* delete btn */}
                                      <button
                                        onClick={() =>
                                          confirmDelete(sub.id!, "sub")
                                        }
                                        className="p-1.5 text-slate-500 hover:text-rose-500"
                                      >
                                        <Trash2 size={14} />
                                      </button>
                                    </div>
                                  )}
                                </div>
                              ))
                          )}
                        </div>
                      </td>
                    </tr>
                  )}
                </React.Fragment>
              ))
            )}
          </tbody>
        </table>
      </div>

      {/* CategoryModal for editing and adding a category  */}
      {!isAdmin && currentCat !== null ? null : (
        <CategoryModal
          editingCategory={currentCat}
          catBaseUrl={catBaseUrl}
          isOpen={isCatModalOpen}
          onClose={() => {
            setIsCatModalOpen(false);
            setCurrentCat(null);
            fetchData();
          }}
        />
      )}

      {/* SubcategoryModal for editing and adding a subcategory  */}
      {!isAdmin && currentSub !== null ? null : (
        <SubcategoryModal
          categoryId={subcatCategory_id}
          editingSubcategory={currentSub}
          subBaseUrl={subBaseUrl}
          isOpen={isSubModalOpen}
          onClose={() => {
            setIsSubModalOpen(false);
            setCurrentCat(null);
            fetchData();
          }}
        />
      )}

      {/* ConfirmDeletionModal for deleting a category or subcategory  */}
      {!isAdmin ? null : (
        <ConfirmDeletionModal
          deleteTarget={deleteTarget}
          endpoint={deleteTarget?.type === "cat" ? catBaseUrl : subBaseUrl}
          isOpen={isDeleteModalOpen}
          onClose={() => {
            setIsDeleteModalOpen(false);
            fetchData();
          }}
        />
      )}
    </div>
  );
}

export default CategoriesPage;

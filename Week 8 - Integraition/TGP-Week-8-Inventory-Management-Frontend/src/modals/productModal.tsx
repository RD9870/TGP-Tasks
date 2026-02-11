import React, { useEffect, useState } from "react";
import api from "../api";
import {
  Modal,
  ModalHeader,
  ModalBody,
  Button,
  Label,
  TextInput,
  Select,
} from "flowbite-react";
import type { DetailedProduct } from "../types/detailedProduct";
import toast from "react-hot-toast";

// pop up to add or edit products

// define the props
interface ProductModalProps {
  isOpen: boolean;
  onClose: () => void;
  editingProduct: DetailedProduct | null;
  onSuccess: () => void;
}

function ProductModal({
  isOpen,
  onClose,
  editingProduct,
  onSuccess,
}: ProductModalProps) {
  // initialize the empty form data
  const [formData, setFormData] = useState({
    name: "",
    code: "",
    price: "",
    subcategory_id: "",
    manufacture_id: "",
    import_company_id: "",
    minimum: "10",
    quantity: "0",
    cost_price: "",
    image: "",
  });

  // initalize the subcategories list
  const [subcategories, setSubcategories] = useState<
    { id: number; name: string }[]
  >([]);

  // initalize manufactoreres
  const [manufacturers, setManufacturers] = useState<
    { id: number; name: string }[]
  >([]);

  // initalize the import compony
  const [importCompanies, setImportCompanies] = useState<
    { id: number; name: string }[]
  >([]);

  // get the dropdowns data from the bckend when the moadel is opened
  useEffect(() => {
    if (isOpen) {
      const fetchData = async () => {
        try {
          const [subRes, manRes, impRes] = await Promise.all([
            api.get("/subcategories"),
            api.get("/manufacturers"),
            api.get("/import-companies"),
          ]);
          setSubcategories(subRes.data);
          setManufacturers(manRes.data);
          setImportCompanies(impRes.data);
        } catch (err) {
          console.error("Failed to fetch dropdown data", err);
        }
      };
      fetchData();
    }
  }, [isOpen]);

  // if the moadel is opened in editing mode fill the form with the product data from the backend
  useEffect(() => {
    if (editingProduct) {
      setFormData({
        name: editingProduct.name,
        code: editingProduct.code,
        price: String(editingProduct.price),
        subcategory_id: String(editingProduct.subcategory_id),
        manufacture_id: String(editingProduct.manufacture_id),
        import_company_id: String(editingProduct.import_company_id),
        minimum: String(editingProduct.minimum),
        quantity: String(editingProduct.quantity),
        cost_price: String(editingProduct.cost_price),
        image: editingProduct.image || "",
      });
    }
    // if moadel is opened in adding mode initialize the form to empty values
    // this reset the values if the user edits then adds something
    else {
      setFormData({
        name: "",
        code: "",
        price: "",
        subcategory_id: "",
        manufacture_id: "",
        import_company_id: "",
        minimum: "10",
        quantity: "0",
        cost_price: "",
        image: "",
      });
    }
  }, [editingProduct, isOpen]);

  // submit changes or additions
  const handleSubmit = async (e: React.FormEvent) => {
    // prevent reloading the page
    e.preventDefault();
    // parse the data to match the expected types from the api
    const dataToSubmit = {
      ...formData, //if the data is an update this makes sure unedited fields are not lost
      price: parseFloat(formData.price),
      subcategory_id: parseInt(formData.subcategory_id),
      manufacture_id: parseInt(formData.manufacture_id),
      import_company_id: parseInt(formData.import_company_id),
      minimum: parseInt(formData.minimum),
      quantity: parseInt(formData.quantity),
      cost_price: formData.cost_price
        ? parseFloat(formData.cost_price)
        : undefined,
    };

    // send the data through the correct api request
    try {
      if (editingProduct) {
        await api.put(`products/${editingProduct.id}`, dataToSubmit);
      } else {
        await api.post(`products`, dataToSubmit);
      }
      // show feedback to the user
      onSuccess();
      // close the pop up
      onClose();
    } catch (err: any) {
      toast.error("Submit failed");
      console.error("Submit failed", err);
    }
  };

  // style fixes
  const inputFix = "[&_input]:!text-black [&_input]:!bg-white";
  const selectFix = "[&_select]:!text-black [&_select]:!bg-white";

  // popup
  return (
    <Modal show={isOpen} onClose={onClose} size="lg">
      {/* title add or edit */}
      <ModalHeader className="bg-slate-900 border-slate-800">
        <span className="text-white">
          {editingProduct ? "Edit Product" : "Add New Product"}
        </span>
      </ModalHeader>

      {/* form */}
      <ModalBody className="bg-slate-900">
        <form onSubmit={handleSubmit} className="space-y-4">
          <div className="grid grid-cols-2 gap-4">
            {/* name */}
            <div className="col-span-2">
              <Label className="text-slate-300">Product Name</Label>
              <TextInput
                className={inputFix}
                value={formData.name}
                onChange={(e) =>
                  setFormData({ ...formData, name: e.target.value })
                }
                required
              />
            </div>

            {/* code */}
            <div>
              <Label className="text-slate-300">Code</Label>
              <TextInput
                className={inputFix}
                value={formData.code}
                onChange={(e) =>
                  setFormData({ ...formData, code: e.target.value })
                }
                required
              />
            </div>

            {/* price */}
            <div>
              <Label className="text-slate-300">Price</Label>
              <TextInput
                className={inputFix}
                type="number"
                value={formData.price}
                onChange={(e) =>
                  setFormData({ ...formData, price: e.target.value })
                }
                required
              />
            </div>

            {/* subcategory dropdown */}
            <div>
              <Label className="text-slate-300">Subcategory</Label>
              <Select
                className={selectFix}
                value={formData.subcategory_id}
                onChange={(e) =>
                  setFormData({ ...formData, subcategory_id: e.target.value })
                }
                required
              >
                {/* options list */}
                <option value="">Select Subcategory</option>
                {subcategories.map((item) => (
                  <option key={item.id} value={item.id}>
                    {item.name}
                  </option>
                ))}
              </Select>
            </div>

            {/* manufactores dropdown */}
            <div>
              <Label className="text-slate-300">Manufacture</Label>
              <Select
                className={selectFix}
                value={formData.manufacture_id}
                onChange={(e) =>
                  setFormData({ ...formData, manufacture_id: e.target.value })
                }
                required
              >
                {/* options list */}
                <option value="">Select Manufacture</option>
                {manufacturers.map((item) => (
                  <option key={item.id} value={item.id}>
                    {item.name}
                  </option>
                ))}
              </Select>
            </div>

            {/* import company dropdown */}
            <div>
              <Label className="text-slate-300">Import Company</Label>
              <Select
                className={selectFix}
                value={formData.import_company_id}
                onChange={(e) =>
                  setFormData({
                    ...formData,
                    import_company_id: e.target.value,
                  })
                }
                required
              >
                {/* options list */}
                <option value="">Select Company</option>
                {importCompanies.map((item) => (
                  <option key={item.id} value={item.id}>
                    {item.name}
                  </option>
                ))}
              </Select>
            </div>

            {/* stock minimum */}
            <div>
              <Label className="text-slate-300">Minimum Amount</Label>
              <TextInput
                className={inputFix}
                type="number"
                value={formData.minimum}
                onChange={(e) =>
                  setFormData({ ...formData, minimum: e.target.value })
                }
                required
              />
            </div>

            {/* current stock quantity */}
            {/* not editable in edit mode bc it decreases automatically when cashier creates a recipt */}
            {editingProduct ? null : (
              <>
                <div>
                  <Label className="text-slate-300">Quantity</Label>
                  <TextInput
                    className={inputFix}
                    type="number"
                    value={formData.quantity}
                    onChange={(e) =>
                      setFormData({ ...formData, quantity: e.target.value })
                    }
                    required
                  />
                </div>
                <div>
                  <Label className="text-slate-300">Cost Price</Label>
                  <TextInput
                    className={inputFix}
                    type="number"
                    value={formData.cost_price}
                    onChange={(e) =>
                      setFormData({ ...formData, cost_price: e.target.value })
                    }
                    required
                  />
                </div>
              </>
            )}

            {/* image url for the thumbnail */}
            <div className="col-span-2">
              <Label className="text-slate-300">Image URL</Label>
              <TextInput
                className={inputFix}
                type="url"
                placeholder="https://example.com/image.jpg"
                value={formData.image}
                onChange={(e) =>
                  setFormData({ ...formData, image: e.target.value })
                }
              />
            </div>
          </div>

          {/* action btns */}
          <div className="flex justify-end gap-2 mt-6">
            {/* cancel btn */}
            <Button className="p-3 bg-gray-500" onClick={onClose}>
              Cancel
            </Button>

            {/* submit btn */}
            <Button className="p-3 bg-blue-600" type="submit">
              {editingProduct ? "Update" : "Save"}
            </Button>
          </div>
        </form>
      </ModalBody>
    </Modal>
  );
}

export default ProductModal;

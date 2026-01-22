import React, { useEffect, useState } from "react";
import ax from "../api/api";
import TextField from "../components/textField";
import Btn from "../components/btn";
import type { Product } from "../types/productType";
import toast from "react-hot-toast";

interface AddProductProps {
  productToEdit?: Product | null;
  onSuccess: () => void;
}

function AddProduct({ productToEdit, onSuccess }: AddProductProps) {
  const [isClicked, setIsClicked] = useState<boolean>(false);

  const initialForm = {
    id: "",
    title: "",
    description: "",
    category: "",
    price: 0,
    rating: 0,
    stock: 0,
    brand: "",
    images: [] as string[],
  };

  const [form, setForm] = useState(initialForm);

  useEffect(() => {
    if (productToEdit) {
      setForm({
        id: productToEdit.id.toString(), // Ensure ID is string if state expects it
        title: productToEdit.title,
        description: productToEdit.description,
        category: productToEdit.category,
        price: productToEdit.price,
        rating: productToEdit.rating,
        stock: productToEdit.stock,
        brand: productToEdit.brand,
        images: productToEdit.images || [],
      });
    } else {
      setForm(initialForm);
    }
  }, [productToEdit]);

  const onFormChange = (
    e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>
  ) => {
    setForm({
      ...form,
      [e.target.name]: e.target.value,
    });
  };

  const submitForm = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      setIsClicked(true);
      await ax.post("/products/add", form);
      toast.success("Product added successfully!");
      onSuccess();
    } catch (err) {
      console.error(err);
      toast.error("Sorry, something is wrong. Please try again later.");
    } finally {
      setIsClicked(false);
    }
  };

  const submitUpdateForm = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      await ax.put(`/products/${productToEdit?.id}`, form, {
        headers: { "Content-Type": "application/json" },
      });
      toast.success(`${productToEdit?.title} has updated sucsessfully`);
      onSuccess();
    } catch (err) {
      console.error(err);
      toast.error("Something went wrong. Please try again.");
    } finally {
      setIsClicked(false);
    }
  };

  return (
    <div>
      <form onSubmit={submitForm}>
        <h1 className="text-2xl font-bold mb-5">
          {productToEdit ? "Edit This Product" : "Add New Product"}
        </h1>

        <div className="grid grid-flow-col grid-rows-3 gap-4">
          <TextField
            type="text"
            label="product name"
            textColor="black"
            value={form.title}
            onChange={onFormChange}
            name="title"
          />
          <TextField
            value={form.description}
            type="text"
            label="Product description"
            textColor="black"
            onChange={onFormChange}
            name="description"
          />
          <TextField
            type="text"
            label="category"
            textColor="black"
            value={form.category}
            onChange={onFormChange}
            name="category"
          />

          <TextField
            type="number"
            label="price"
            textColor="black"
            value={form.price.toString()}
            onChange={onFormChange}
            name="price"
          />
          <TextField
            type="number"
            label="current stock"
            textColor="black"
            value={form.stock.toString()}
            onChange={onFormChange}
            name="stock"
          />

          <TextField
            type="text"
            label="brand"
            textColor="black"
            value={form.brand}
            onChange={onFormChange}
            name="brand"
          />
        </div>
        <div className="mt-5 w-fit flex flex-row gap-1.5">
          {/* <TextField type="file" label="images" textColor="black" /> */}
          <h4>Images:</h4> <input type="file" name="images" />
        </div>
      </form>

      <div className="w-full flex justify-end mt-5">
        <Btn
          color="bg-primary-btn"
          label={productToEdit ? "Update Product" : "Add New Product"}
          whenClicked={productToEdit ? submitUpdateForm : submitForm}
          disable={isClicked}
        />
      </div>
    </div>
  );
}

export default AddProduct;

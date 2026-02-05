import React, { useEffect, useState } from "react";
import ax from "../api/api";
import TextField from "../components/textField";
import Btn from "../components/btn";
import type { Product } from "../types/productType";
import toast from "react-hot-toast";

// page where user can add a new product or edit an existing one

// define the props for the add product component
interface AddProductProps {
  // if productToEdit is provided the form will be pre-filled with the product data and the user can edit it, if not the form will be empty and the user can add a new product
  productToEdit?: Product | null;
  // add a new product to the database or update an existing one
  onSuccess: () => void;
}

function AddProduct({ productToEdit, onSuccess }: AddProductProps) {
  const [isClicked, setIsClicked] = useState<boolean>(false);

  // define the initial state of the form
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

  // useState hook to save the changes to the form as the user types
  const [form, setForm] = useState(initialForm);

  // useEffect hook to initiate the form
  useEffect(() => {
    //  if productToEdit is provided pre-fill the form with the product data
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
    e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>,
  ) => {
    // update the form as the user types
    setForm({
      ...form, // this insures that other form fields are not erased when one field is updated
      [e.target.name]: e.target.value,
    });
  };

  // add new product form submission handler
  const submitForm = async (e: React.FormEvent) => {
    // prevent the default form submission behavior (collect and send the form data to the url specified in actions attribute and relode the page)
    e.preventDefault();
    try {
      // make the button unclickable to prevent multiple requests being sent
      setIsClicked(true);
      // send a post request to the api with the form data
      await ax.post("/products/add", form);
      // show a success message and
      toast.success("Product added successfully!");
      // call the onSuccess callback
      onSuccess();
    } catch (err) {
      // print error to console
      console.error(err);
      // show an error message to the user
      toast.error("Sorry, something is wrong. Please try again later.");
    } finally {
      // make the button clickable again
      setIsClicked(false);
    }
  };

  // handel updateing an existing product form submission
  const submitUpdateForm = async (e: React.FormEvent) => {
    // prevent the default form submission behavior (collect and send the form data to the url specified in actions attribute and relode the page)
    e.preventDefault();
    try {
      // send an api request to update the product with the form data as the request body
      await ax.put(`/products/${productToEdit?.id}`, form, {
        headers: { "Content-Type": "application/json" },
      });
      // show a success message and call the onSuccess callback
      toast.success(`${productToEdit?.title} has updated sucsessfully`);
      onSuccess();
    } catch (err) {
      // in case of an error print it to the console and show an error message to the user
      console.error(err);
      toast.error("Something went wrong. Please try again.");
    } finally {
      // make the submit button clickable again
      setIsClicked(false);
    }
  };

  return (
    <div>
      <form onSubmit={submitForm}>
        {/* page title */}
        <h1 className="text-2xl font-bold mb-5">
          {productToEdit ? "Edit This Product" : "Add New Product"}
        </h1>

        <div className="grid grid-flow-col grid-rows-3 gap-4">
          {/* product name */}
          <TextField
            type="text"
            label="product name"
            textColor="black"
            value={form.title}
            onChange={onFormChange}
            name="title"
          />

          {/* description */}
          <TextField
            value={form.description}
            type="text"
            label="Product description"
            textColor="black"
            onChange={onFormChange}
            name="description"
          />

          {/* category */}
          <TextField
            type="text"
            label="category"
            textColor="black"
            value={form.category}
            onChange={onFormChange}
            name="category"
          />

          {/* price */}
          <TextField
            type="number"
            label="price"
            textColor="black"
            value={form.price.toString()}
            onChange={onFormChange}
            name="price"
          />

          {/* stock */}
          <TextField
            type="number"
            label="current stock"
            textColor="black"
            value={form.stock.toString()}
            onChange={onFormChange}
            name="stock"
          />

          {/* brand */}
          <TextField
            type="text"
            label="brand"
            textColor="black"
            value={form.brand}
            onChange={onFormChange}
            name="brand"
          />
        </div>

        {/* images list */}
        <div className="mt-5 w-fit flex flex-row gap-1.5">
          {/* <TextField type="file" label="images" textColor="black" /> */}
          <h4>Images:</h4> <input type="file" name="images" />
        </div>
      </form>

      {/* submission button */}
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

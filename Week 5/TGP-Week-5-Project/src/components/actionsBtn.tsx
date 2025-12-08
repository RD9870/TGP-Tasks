import React, { useState } from "react";
import Btn from "./btn";

interface ActionsBtnProps {
  onEdit: () => void;
  onDelete: () => void;
}

function ActionsBtn({ onEdit, onDelete }: ActionsBtnProps) {
  const [isOpen, setIsOpen] = useState(false);
  return (
    <div className="relative">
      <button
        onClick={() => {
          setIsOpen(!isOpen);
        }}
      >
        <img src="../assets/action.svg" />
      </button>
      {isOpen && (
        <div className="flex flex-col absolute right-0 top-3 mt-2 w-fit bg-white rounded-lg shadow-lg border border-gray-100 z-10 overflow-hidden">
          <ul className="flex flex-col gap-2  p-0 m-0  list-none ">
            <li className="text-center p-2">
              <button
                onClick={() => {
                  setIsOpen(!isOpen);
                  onEdit();
                }}
              >
                Edit
              </button>
            </li>
            <li className="text-center p-2">
              <button
                onClick={() => {
                  setIsOpen(!isOpen);
                  onDelete();
                }}
              >
                Delete
              </button>
            </li>
          </ul>
        </div>
      )}
    </div>
  );
}

export default ActionsBtn;

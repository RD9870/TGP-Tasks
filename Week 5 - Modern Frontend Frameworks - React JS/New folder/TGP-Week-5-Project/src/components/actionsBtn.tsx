import { useState } from "react";

// an interface to define the props for ActionsBtn component
interface ActionsBtnProps {
  onEdit: () => void;
  onDelete: () => void;
}

function ActionsBtn({ onEdit, onDelete }: ActionsBtnProps) {
  // a use state to manage the visibility of the dropdown menu
  const [isOpen, setIsOpen] = useState(false);
  return (
    //  the classname "relative" is used to position the dropdown menu absolutely within this container
    <div className="relative">
      {/* a button with an image of three dots to create the toggles of the dropdown menu */}
      <button
        onClick={() => {
          setIsOpen(!isOpen);
        }}
      >
        <img src="../assets/action.svg" />
      </button>
      {/* if the button is open show the dropdown menu of the edit and delete options */}
      {isOpen && (
        <div className="flex flex-col absolute right-0 top-3 mt-2 w-fit bg-white rounded-lg shadow-lg border border-gray-100 z-10 overflow-hidden">
          {/* a list of buttons */}
          <ul className="flex flex-col gap-2  p-0 m-0  list-none ">
            {/* the edit button */}
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

            {/* the delete button */}
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

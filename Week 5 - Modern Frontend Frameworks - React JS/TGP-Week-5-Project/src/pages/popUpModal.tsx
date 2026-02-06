import React from "react";

// define the props for the PopUpModal component
interface PopUpModalProps {
  // the content inside the modal as a react node
  children: React.ReactNode;
  isOpen: boolean;
  onClose: () => void;
}

function PopUpModal({ children, isOpen, onClose }: PopUpModalProps) {
  return isOpen ? (
    // show product details in a popup
    <div className="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
      <div className="bg-white p-6 rounded-lg shadow-xl relative w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        {/* exit button */}
        <button onClick={onClose} className="absolute top-4 right-4">
          <img src="../public/assets/x.svg" alt="X" />
        </button>
        {/* products details */}
        {children}
      </div>
    </div>
  ) : null;
}

export default PopUpModal;

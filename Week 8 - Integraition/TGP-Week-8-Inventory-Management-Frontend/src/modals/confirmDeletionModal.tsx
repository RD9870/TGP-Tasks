import { Modal, ModalBody, ModalHeader } from "flowbite-react";
import { AlertTriangle } from "lucide-react";
import toast from "react-hot-toast";
import api from "../api";

interface ConfirmDeletionModalProps {
  isOpen: boolean;
  //   isAdmin: boolean;
  endpoint: string;
  deleteTarget: {
    id: number;
    type: "cat" | "sub";
  } | null;
  onClose: () => void;
}

function ConfirmDeletionModal({
  isOpen,
  endpoint,
  deleteTarget,
  onClose,
}: ConfirmDeletionModalProps) {
  // inits
  const executeDelete = async () => {
    if (!deleteTarget) return;
    const tid = toast.loading("Deleting...");
    try {
      //   const endpoint = deleteTarget.type === "cat" ? catBaseUrl : subBaseUrl;
      await api.delete(`${endpoint}/${deleteTarget.id}`);
      toast.success("Deleted successfully", { id: tid });
      //   fetchData();
      //   setIsDeleteModalOpen(false);
      onClose();
    } catch (err) {
      toast.error("Failed to delete", { id: tid });
    }
  };
  // model
  return (
    <>
      <Modal show={isOpen} onClose={onClose} size="lg">
        {/* title add or edit */}
        <ModalHeader className="bg-slate-900 border-slate-800">
          <span className="text-white">{"Are you sure?"}</span>
        </ModalHeader>

        {/* form */}
        <ModalBody className="bg-slate-900"></ModalBody>
        <div className="fixed inset-0 bg-slate-950/90 backdrop-blur-sm flex justify-center items-center p-4 z-60  animate-in zoom-in duration-150">
          <div className="bg-slate-900 border border-slate-800 p-8 rounded-4xl max-w-sm w-full text-center shadow-2xl">
            <div className="w-16 h-16 bg-rose-500/10 text-rose-500 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-rose-500/20">
              <AlertTriangle size={32} />
            </div>
            <h3 className="text-xl font-bold mb-2 text-white">Are you sure?</h3>
            <p className="text-slate-400 mb-8 text-sm leading-relaxed">
              {deleteTarget?.type === "cat"
                ? "Warning: Deleting a category will also delete all its subcategories!"
                : "This subcategory will be permanently removed."}
            </p>
            <div className="flex gap-3">
              <button
                type="button"
                onClick={() => onClose()}
                className="flex-1 bg-slate-800 text-slate-300 py-3 rounded-xl font-bold hover:bg-slate-700"
              >
                Cancel
              </button>
              <button
                type="button"
                onClick={executeDelete}
                className="flex-1 bg-rose-600 text-white py-3 rounded-xl font-bold shadow-lg hover:bg-rose-500 active:scale-95"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </Modal>
    </>
  );
}

export default ConfirmDeletionModal;

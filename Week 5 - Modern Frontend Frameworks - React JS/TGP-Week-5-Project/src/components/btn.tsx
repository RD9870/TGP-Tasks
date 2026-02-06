// interface to define the props for Btn component
interface BtnProps {
  label: string;
  color: string;
  whenClicked: (...args: any[]) => any;
  disable: boolean;
}
function Btn({ label: label, color, whenClicked, disable }: BtnProps) {
  return (
    <button
      // the reguler and disabled color schemes
      className={`text-white ${color} rounded-lg p-4 capitalize         
      ${disable ? "opacity-50 cursor-not-allowed" : ""} `}
      // function to be called when the button is clicked
      onClick={whenClicked}
      // variable to know id the btn has been clicked
      disabled={disable}
    >
      {/* button text */}
      {label}
    </button>
  );
}

export default Btn;

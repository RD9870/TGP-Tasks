interface BtnProps {
  label: string;
  color: string;
  whenClicked: (...args: any[]) => any;
  disable: boolean;
}
function Btn({ label: label, color, whenClicked, disable }: BtnProps) {
  return (
    <button
      className={`text-white ${color} rounded-lg p-4 capitalize         ${
        disable ? "opacity-50 cursor-not-allowed" : ""
      } `}
      onClick={whenClicked}
      disabled={disable}
    >
      {label}
    </button>
  );
}

export default Btn;

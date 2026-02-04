// interface for text field component props
interface TextFieldProps {
  label: string;
  icon?: string;
  type: string;
  id?: string;
  textColor: string;
  // text field value can be string, number or array of strings
  value: string | number | string[];
  // when the user types in or deletes the text field this function is called
  onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
  name: string;
}

function TextField({
  label,
  icon,
  type,
  id,
  textColor,
  value,
  name,
  onChange,
}: TextFieldProps) {
  return (
    <>
      <div className="relative w-full">
        {/* text field name */}
        <label
          className={`font-bold text-${textColor} capitalize font-bold  text-sm `}
          htmlFor={name}
        >
          {label}
        </label>

        {/* text field input */}
        <input
          type={type}
          id={id}
          className={`bg-neutral-secondary-medium w-full border-0 border-b-2 border-white px-3 py-2.5 text-sm text-${textColor} shadow-xs outline-none placeholder:font-bold placeholder:text-${textColor} placeholder:capitalize focus:border-gray-500`}
          value={value}
          onChange={onChange}
          name={name}
        />

        {/* text field icon */}
        <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
          <img src={icon} />
        </div>
      </div>
    </>
  );
}

export default TextField;

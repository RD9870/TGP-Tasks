import { Link } from "react-router-dom";

interface NavListItemProps {
  title: string;
  icon: string;
  whenClicked: () => void;
  distination: string;
}

function NavListItem({
  title,
  icon,
  distination,
  whenClicked,
}: NavListItemProps) {
  return (
    <Link to={`/dashboard/${distination}`} onClick={whenClicked}>
      <li>
        <div className="flex flex-row">
          <img src={icon} />
          <button className="block w-full text-left py-2 px-4 hover:bg-orange-300 rounded">
            {title}
          </button>
        </div>
      </li>
    </Link>
  );
}

export default NavListItem;

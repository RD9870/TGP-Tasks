import { Link } from "react-router-dom";

// a navigation list item component

// interface for the component props
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
    // navigation link wrapping the nav list item
    <Link to={`/dashboard/${distination}`} onClick={whenClicked}>
      <li>
        <div className="flex flex-row">
          {/* the icon for the navigation item */}
          <img src={icon} />
          {/* navigation item title */}
          <button className="block w-full text-left py-2 px-4 hover:bg-orange-300 rounded">
            {title}
          </button>
        </div>
      </li>
    </Link>
  );
}

export default NavListItem;

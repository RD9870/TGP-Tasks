import { Link } from "react-router-dom";

interface SidebarItem {
  id: string;
  label: string;
  path: string;
}

interface SidebarProps {
  currentPath?: string;
  isMobileMenuOpen?: boolean;
  setIsMobileMenuOpen?: (open: boolean) => void;
}

// all the potential sidebaritems
const defaultItems: SidebarItem[] = [
  {
    id: "dashboard",
    label: "Dashboard",
    path: "/dashboard",
  },
  {
    id: "users",
    label: "Users",
    path: "/users",
  },
  {
    id: "products",
    label: "products",
    path: "/products",
  },
  {
    id: "categories",
    label: "Categories",
    path: "/categories",
  },
  {
    id: "profits",
    label: "Profits",
    path: "/profitDetails",
  },
];

function Sidebar({
  currentPath,
  isMobileMenuOpen,
  setIsMobileMenuOpen,
}: SidebarProps) {
  // get the path user is currently in
  const activePath = currentPath;
  // get user type
  const userType = localStorage.getItem("user_type")!.trim().toLowerCase();
  //
  // const isAdmin = userType === "admin";

  // filter the items base on the role
  const filteredItems = defaultItems.filter((item) => {
    // if the type is not admin
    if (userType != "admin") {
      const itemId = item.id.toLowerCase();
      const itemPath = item.path.toLowerCase();

      // the path include one of these keywords skip them
      if (
        itemId.includes("user") ||
        itemId.includes("profit") ||
        itemPath.includes("profit")
      ) {
        return false;
      }
    }
    return true;
  });

  return (
    <>
      {/* Overlay for mobile */}
      {isMobileMenuOpen && (
        <div
          className="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
          onClick={() => setIsMobileMenuOpen?.(false)}
        />
      )}

      {/* Sidebar Desktop */}
      <aside className="hidden md:block fixed left-0 top-0 h-screen w-60 bg-gray-800 text-white z-30">
        <div className="p-6 border-b border-gray-700">
          <h1 className="text-xl font-bold">Storage Manager</h1>
        </div>
        <nav>
          {/* map the filtered nav items to the side bar */}
          {filteredItems.map((item) => {
            //  color the text based on activity
            const isActive = activePath === item.path;
            const itemClasses = isActive
              ? "flex items-center gap-3 px-6 py-3 bg-red-500 hover:bg-primary-600 transition-colors"
              : "flex items-center gap-3 px-6 py-3 text-gray-300 hover:bg-gray-700 transition-colors";

            // retuen item
            return (
              <Link key={item.id} to={item.path} className={itemClasses}>
                <span>{item.label}</span>
              </Link>
            );
          })}
        </nav>
      </aside>

      {/* Sidebar Mobile */}
      <aside
        className={`md:hidden fixed left-0 top-0 h-screen w-60 bg-gray-800 text-white z-50 transform transition-transform duration-300 ease-in-out ${
          isMobileMenuOpen ? "translate-x-0" : "-translate-x-full"
        }`}
      >
        <div className="p-6 border-b border-gray-700 flex items-center justify-between">
          <h1 className="text-xl font-bold">Storage Manager</h1>
          <button
            onClick={() => setIsMobileMenuOpen?.(false)}
            className="text-gray-300 hover:text-white"
          >
            {/* menure icon */}
            <svg
              className="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
        <nav>
          {/* map the filtered nav items to the side bar on mobile*/}
          {filteredItems.map((item) => {
            //  color the text based on activity
            const isActive = activePath === item.path;
            const itemClasses = isActive
              ? "flex items-center gap-3 px-6 py-3 bg-primary-500 hover:bg-primary-600 transition-colors"
              : "flex items-center gap-3 px-6 py-3 text-gray-300 hover:bg-gray-700 transition-colors";

            // retuen item
            return (
              <Link
                key={item.id}
                to={item.path}
                className={itemClasses}
                onClick={() => setIsMobileMenuOpen?.(false)}
              >
                <span>{item.label}</span>
              </Link>
            );
          })}
        </nav>
      </aside>
    </>
  );
}

export default Sidebar;

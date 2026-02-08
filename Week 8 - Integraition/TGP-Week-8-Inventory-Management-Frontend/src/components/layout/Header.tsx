import { Menu, LogOut, User } from "lucide-react";
import { useNavigate } from "react-router-dom";

interface HeaderProps {
  userRole: string;
  userName: string;
  onMenuClick?: () => void;
}

function Header({ userRole, userName, onMenuClick }: HeaderProps) {
  const navigate = useNavigate();

  // logout
  const handleLogout = () => {
    //remove tokens from localStorage
    localStorage.removeItem("token");
    localStorage.clear();

    //redirect to login page
    navigate("/login");
    window.location.reload();
  };

  return (
    <header className="h-16 bg-transparent border-b border-gray-200 flex items-center justify-between px-4 md:px-6">
      <div className="flex items-center gap-3">
        {/* menue btn for the small screens */}
        <button
          onClick={onMenuClick}
          className="md:hidden text-white hover:text-gray-200"
        >
          <Menu size={24} />
        </button>
      </div>
      <div className="flex items-center gap-4">
        {/* User Info and greeting Section */}
        <div className="hidden md:flex flex-col items-end mr-2">
          <span className="text-sm font-medium text-slate-200">
            Hello, {userName}
          </span>
          <span className="text-xs text-slate-500">{userRole}</span>
        </div>

        {/* Profile Avatar / Icon */}
        <div className="h-9 w-9 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center overflow-hidden">
          <User size={20} className="text-slate-400" />
        </div>

        {/* Logout Button */}
        <button
          onClick={handleLogout}
          className="flex items-center gap-2 px-3 py-2 text-sm font-medium text-rose-400 hover:bg-rose-500/10 rounded-lg transition-all duration-200"
          title="Logout"
        >
          <LogOut size={20} />
          <span className="hidden sm:inline">Logout</span>
        </button>
      </div>
    </header>
  );
}

export default Header;

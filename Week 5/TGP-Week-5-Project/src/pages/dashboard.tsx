import { Outlet, useNavigate } from "react-router-dom";
import NavListItem from "../components/nav-lis-item";
import { useEffect, useState } from "react";
import ax from "../api/api";
import type { User } from "../types/user";
import SearchBox from "../components/searchBox";

function Dashboard() {
  const navigate = useNavigate();

  const logout = () => {
    localStorage.removeItem("token");
    localStorage.removeItem("refreshToken");
    navigate("/");
  };

  const [currentUser, setCurrentUser] = useState<User | null>(null);
  const [isOpen, setIsOpen] = useState(false);

  useEffect(() => {
    const getUser = async () => {
      try {
        const userAuth = await ax.get("/auth/me");
        setCurrentUser(userAuth.data);
      } catch (error) {
        console.error("Failed to authanticate user:", error);
      }
    };
    getUser();
  }, []);

  return currentUser ? (
    <div className="flex w-full min-h-screen bg-gray-100  flex-row relative">
      {/* <div className="w-64 bg-nav-orage text-white p-4 flex flex-col "> */}
      <div
        className={`${
          isOpen ? "flex" : "hidden"
        } min-w-fit min-h-screen bg-nav-orage text-white p-4 flex flex-col md:flex`}
      >
        <img src="/assets/logo.png" className="h-30 w-30 mx-auto" />
        <h2 className="text-2xl font-semibold mb-6 capitalize text-center">
          at a glance system
        </h2>
        <div>
          <SearchBox />
        </div>
        <ul>
          <NavListItem
            icon="/assets/products.svg"
            title="inventory"
            distination="products"
            whenClicked={() => {
              setIsOpen(false);
            }}
          />
          <NavListItem
            icon="/assets/stock.svg"
            title="out of stock"
            distination="OutOfStock"
            whenClicked={() => {
              setIsOpen(false);
            }}
          />
        </ul>
        <div className="flex items-center space-x-4 mt-auto">
          <img src={currentUser.image} className="w-8 h-8 rounded-full" />
          <div className="text-xs align-bottom ">
            <p>
              Hello {currentUser.firstName} {currentUser.lastName}
            </p>
            <p className="text-gray-400">{currentUser.email}</p>
          </div>
        </div>
      </div>

      <div className="flex-1 flex flex-col w-screen">
        <header className="bg-white shadow p-4 flex justify-between items-center w-full">
          <div className="flex w-full justify-between md:justify-end space-x-4">
            <button className="md:hidden" onClick={() => setIsOpen(!isOpen)}>
              <img src="/assets/menu.svg" />
            </button>

            <button onClick={logout}>
              <img src="/assets/log-out.svg" />
            </button>
          </div>
        </header>

        <div className=" p-4 flex w-full h-full">
          <Outlet />
        </div>
      </div>
    </div>
  ) : (
    <div className="w-full h-screen flex items-center justify-center flex-col gap-4">
      <div className="flex items-center justify-center bg-neutral-secondary-soft h-56 w-56 border border-default text-fg-brand-strong text-xs font-medium rounded-base">
        <div className="px-2 py-px ring-1 ring-inset ring-brand-subtle text-fg-brand-strong text-xs font-medium rounded-sm bg-brand-softer animate-pulse">
          loading...
        </div>
      </div>
    </div>
  );
}

export default Dashboard;

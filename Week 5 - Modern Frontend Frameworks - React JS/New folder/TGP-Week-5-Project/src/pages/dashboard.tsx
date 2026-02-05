import { Outlet, useNavigate } from "react-router-dom";
import NavListItem from "../components/nav-lis-item";
import { useEffect, useState } from "react";
import ax from "../api/api";
import type { User } from "../types/user";
import SearchBox from "../components/searchBox";

function Dashboard() {
  // navigate hook to navigate to the login page after logout
  const navigate = useNavigate();

  // remove all the stored authentication tokens and navigate to the login page
  const logout = () => {
    localStorage.removeItem("token");
    localStorage.removeItem("refreshToken");
    navigate("/");
  };

  // state to save the current user data
  const [currentUser, setCurrentUser] = useState<User | null>(null);

  // state to control the visibility of the side navigation bar on small screens
  const [isOpen, setIsOpen] = useState(false);

  useEffect(() => {
    // get the current user data from the api and save it in the state use it to display the user's name, email and profile picture in the side navigation bar
    const getUser = async () => {
      try {
        const userAuth = await ax.get("/auth/me");
        setCurrentUser(userAuth.data);
      } catch (error) {
        // if something goes wrong show error
        console.error("Failed to authanticate user:", error);
      }
    };
    getUser();
  }, []);

  // if the user is logged in show dashboard
  return currentUser ? (
    <div className="flex w-full min-h-screen bg-gray-100 ">
      <div
        className={`${
          // make the side navigation bar visible or hidden on small screens when the menu button is clicked
          isOpen ? "flex" : "hidden"
        } min-w-fit min-h-screen bg-nav-orage text-white p-4 flex flex-col md:flex`}
      >
        {/* logo and website title */}
        <img src="/assets/logo.png" className="h-30 w-30 mx-auto" />
        <h2 className="text-2xl font-semibold mb-6 capitalize text-center">
          at a glance system
        </h2>

        {/* search box */}
        <div>
          <SearchBox />
        </div>

        {/* navigation list */}
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

        {/* user data */}
        <div className="flex items-center space-x-4 mt-auto">
          {/* profile picture */}
          <img src={currentUser.image} className="w-8 h-8 rounded-full" />

          {/* greeting by name */}
          <div className="text-xs align-bottom ">
            <p>
              Hello {currentUser.firstName} {currentUser.lastName}
            </p>

            {/* email */}
            <p className="text-gray-400">{currentUser.email}</p>
          </div>
        </div>
      </div>

      <div className="flex-1 flex flex-col w-full">
        <header className="bg-white shadow p-4 flex justify-between items-center">
          <div className="flex w-full justify-between md:justify-end space-x-4">
            {/* menue icon for small screens   */}
            <button className="md:hidden" onClick={() => setIsOpen(!isOpen)}>
              <img src="/assets/menu.svg" />
            </button>

            {/* logout button */}
            <button onClick={logout}>
              <img src="/assets/log-out.svg" />
            </button>
          </div>
        </header>

        <div className=" p-4 flex w-full h-full">
          {/* a place holder component to render the other pages inside the static dashboard components */}
          <Outlet />
        </div>
      </div>
    </div>
  ) : (
    // user is not logged in yet show loading screen
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

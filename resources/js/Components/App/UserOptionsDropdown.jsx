import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/react";
import {
    EllipsisVerticalIcon,
    LockClosedIcon,
    LockOpenIcon,
    ShieldCheckIcon,
    UserIcon,
} from "@heroicons/react/24/solid";
import axios from "axios";

const UserOptionsDropdown = ({ conversation }) => {
    const changeUserRole = () => {
        console.log("change user role");
        if (!conversation.is_user) {
            return;
        }

        axios
            .post(route("user.changeRole", conversation.id))
            .then((res) => {
                console.log(res.data);
            })
            .catch((err) => {
                console.log(err);
            });
    };

    const onBlockUser = () => {
        console.log("Block User");
        if (!conversation.is_user) {
            return;
        }

        axios
            .post(route("user.blockUnblock", conversation.id))
            .then((res) => {
                console.log(res.data);
            })
            .catch((err) => {
                console.log(err);
            });
    };

    return (
        <div>
            <Menu as="div" className="relative inline-block text-left">
                <div>
                    <MenuButton className="flex items-center justify-center w-8 h-8 rounded-t-full hover:bg-black/40">
                        <EllipsisVerticalIcon className="w-5 h-5" />
                    </MenuButton>
                </div>

                <MenuItems
                    transition
                    anchor="bottom end"
                    className="absolute right-0 z-50 w-48 mt-2 bg-gray-800 rounded-md shadow-lg"
                >
                    <div className="px-1 py-1">
                        <MenuItem>
                            {({ active }) => (
                                <button
                                    onClick={onBlockUser}
                                    className={`${
                                        active
                                            ? "bg-black/30 text-white"
                                            : "text-gray-100"
                                    } group flex w-full items-center rounded-md px-2 py-2 text-sm`}
                                >
                                    {conversation.blocked_at && (
                                        <>
                                            <LockOpenIcon className="w-4 h-4 mr-2" />
                                            Unblock User
                                        </>
                                    )}
                                    {!conversation.blocked_at && (
                                        <>
                                            <LockClosedIcon className="w-4 h-4 mr-2" />
                                            Block User
                                        </>
                                    )}
                                </button>
                            )}
                        </MenuItem>
                    </div>

                    <div className="px-1 py-1">
                        <MenuItem>
                            {({ active }) => (
                                <button
                                    onClick={changeUserRole}
                                    className={`${
                                        active
                                            ? "bg-black/30 text-white"
                                            : "text-gray-100"
                                    } group flex w-full items-center rounded-md px-2 py-2 text-sm`}
                                >
                                    {conversation.is_admin && (
                                        <>
                                            <UserIcon className="w-4 h-4 mr-2" />
                                            Make Regular User
                                        </>
                                    )}
                                    {!conversation.is_admin && (
                                        <>
                                            <ShieldCheckIcon className="w-4 h-4 mr-2" />
                                            Make Admin
                                        </>
                                    )}
                                </button>
                            )}
                        </MenuItem>
                    </div>
                </MenuItems>
            </Menu>
        </div>
    );
};

export default UserOptionsDropdown;

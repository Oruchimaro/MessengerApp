import { usePage } from "@inertiajs/react";
import { useEffect } from "react";

const ChatLayout = ({ children }) => {
    const page = usePage();
    const conversations = page.props.conversations;
    const selectedConversation = page.props.selectedConversation;

    console.log("conversations", conversations);
    console.log("selectedConversation", selectedConversation);

    useEffect(() => {
        Echo.join("online")
            .here((users) => console.log("here", users))
            .joining((user) => console.log("joining", user))
            .leaving((user) => console.log("leaving", user))
            .error((error) => console.log("error", error));

        return () => {
            Echo.leave("online");
        };
    }, []);

    return (
        <>
            <div>
                ChatLayout
                <div>{children}</div>
            </div>
        </>
    );
};

export default ChatLayout;

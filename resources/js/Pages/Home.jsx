import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import ChatLayout from "@/Layouts/ChatLayout";

// persistent layout
function Home() {
    return <>Messages HTML</>;
}

Home.layout = (page) => {
    return (
        <AuthenticatedLayout user={page.props.auth.user}>
            <ChatLayout children={page} />
        </AuthenticatedLayout>
    );
};

export default Home;

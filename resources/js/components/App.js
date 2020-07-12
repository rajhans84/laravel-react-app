import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter, Route, Switch } from "react-router-dom";
import Organisations from "./Organisations";
import Edit from "./Edit";
import Header from "./Header";
import Success from "./Success";
import ErrorMessage from "./ErrorMessage";
import { DeleteOrg, DeleteUser } from "./Delete";
import Users from "./Users";
import EditOrganisation from "./EditOrganisation";

function App(props) {
    return (
        <BrowserRouter>
            <div>
                <Header />
                <Switch location={props.location}>
                    <Route exact path="/" component={Users} />
                    <Route path="/organisations" component={Organisations} />
                    <Route path="/org-create" children={<EditOrganisation />} />
                    <Route
                        path="/org-store/:id"
                        children={<EditOrganisation />}
                    />
                    <Route path="/org-delete/:id" children={<DeleteOrg />} />
                    <Route path="/create" children={<Edit />} />
                    <Route path="/store/:id" children={<Edit />} />
                    <Route path="/delete/:id" children={<DeleteUser />} />
                    <Route path="/success" component={Success} />
                    <Route path="/error" component={ErrorMessage} />
                </Switch>
            </div>
        </BrowserRouter>
    );
}

export default App;

if (document.getElementById("example")) {
    ReactDOM.render(<App />, document.getElementById("example"));
}

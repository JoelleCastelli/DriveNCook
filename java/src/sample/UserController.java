package sample;

import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;


public class UserController {
    @FXML
    private TableView<User> userTable;
    @FXML
    private TableColumn<User, String> emailColumn;

    @FXML
    private Label emailLabel;
    @FXML
    private Label firstnameLabel;
    @FXML
    private Label lastnameLabel;
    @FXML
    private Label roleLabel;

    private Main main;

    public UserController() {

    }

    @FXML
    private void initialize() {
        // Initialize the person table with the two columns.

        emailColumn.setCellValueFactory(cellData -> cellData.getValue().emailProperty());

        showUserDetail(null);

        userTable.getSelectionModel().selectedItemProperty().addListener(
                (observable, oldValue, newValue) -> showUserDetail(newValue)
        );
    }

    public void setMainApp(Main main) {
        this.main = main;

        userTable.setItems(main.getUserList());
    }

    private void showUserDetail(User user) {
        if (user != null) {
            emailLabel.setText(user.getEmail());
            firstnameLabel.setText(user.getFirstname());
            lastnameLabel.setText(user.getLastname());
            roleLabel.setText(user.getRole());
        } else {
            emailLabel.setText("");
            firstnameLabel.setText("");
            lastnameLabel.setText("");
            roleLabel.setText("");
        }
    }
}

package javafx;

import javafx.collections.transformation.FilteredList;
import javafx.collections.transformation.SortedList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;

public class UserListController {
    @FXML
    private TableView<User> userTable;
    @FXML
    private TableColumn<User, String> emailColumn;
    @FXML
    private Label loginLabel;
    @FXML
    TextField searchField;

    @FXML
    private Label emailLabel;
    @FXML
    private Label firstnameLabel;
    @FXML
    private Label lastnameLabel;
    @FXML
    private Label roleLabel;

    private User loginUser;

    private MainApp mainApp;

    @FXML
    private void initialize() {
        // Initialize the person table with the two columns.

        emailColumn.setCellValueFactory(cellData -> cellData.getValue().emailProperty());

        showUserDetail(null);

        userTable.getSelectionModel().selectedItemProperty().addListener(
                (observable, oldValue, newValue) -> showUserDetail(newValue)
        );

    }

    public void setMainApp(MainApp main) {
        this.mainApp = main;

//        userTable.setItems(main.getUserList());
        initTableFilter();
    }

    public void setLoginUser(User loginUser) {
        this.loginUser = loginUser;
        loginLabel.setVisible(true);
        loginLabel.setText("Bienvenue : " + this.loginUser.getFirstname() + " " + this.loginUser.getLastname());
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

    private void initTableFilter() {
        FilteredList<User> filteredData = new FilteredList<>(mainApp.getUserList(), p -> true);

        searchField.textProperty().addListener(
                ((observable, oldValue, newValue) -> {
                    filteredData.setPredicate(User -> {
                        if (newValue == null || newValue.isEmpty()) {
                            return true;
                        }

                        String lowerCaseFilter = newValue.toLowerCase();

                        if (User.getEmail().toLowerCase().contains(lowerCaseFilter)) {
                            return true;
                        }
                        return false;
                    });
                }));

        SortedList<User> sortedList = new SortedList<>(filteredData);
        sortedList.comparatorProperty().bind(userTable.comparatorProperty());
        userTable.setItems(sortedList);
    }
}

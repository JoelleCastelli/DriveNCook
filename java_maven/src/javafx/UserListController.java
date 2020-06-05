package javafx;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.collections.transformation.FilteredList;
import javafx.collections.transformation.SortedList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;

public class UserListController {

    private MainApp mainApp;

    //User list
    @FXML
    private TableView<User> userTable;
    @FXML
    private TableColumn<User, String> emailColumn;
    @FXML
    private Label loginLabel;
    @FXML
    TextField searchField;

    //User detail
    private User loginUser;

    @FXML
    private Label emailLabel;
    @FXML
    private Label firstnameLabel;
    @FXML
    private Label lastnameLabel;
    @FXML
    private Label roleLabel;
    @FXML
    private Label orderLabel;

    @FXML
    private TableView<Promotion> promotionTable;
    @FXML
    private TableColumn<Promotion, String> promoTypeColumn;
    @FXML
    private TableColumn<Promotion, String> promoValueColumn;


    @FXML
    private void initialize() {
        // Initialize the person table with the two columns.

        emailColumn.setCellValueFactory(cellData -> cellData.getValue().emailProperty());

        promoTypeColumn.setCellValueFactory(cellData -> cellData.getValue().promo_typeProperty());
        promoValueColumn.setCellValueFactory(cellData -> cellData.getValue().valueProperty());

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
            orderLabel.setText(user.getOrder());
            getUserPromotions(user);
        } else {
            emailLabel.setText("");
            firstnameLabel.setText("");
            lastnameLabel.setText("");
            roleLabel.setText("");
            orderLabel.setText("");
        }
    }

    public void deletePromotion(ActionEvent event) {
        String selected_user_id = userTable.getSelectionModel().getSelectedItem().getId();
        int promo_id = Integer.parseInt(promotionTable.getSelectionModel().getSelectedItem().getId());
        this.mainApp.dataBaseDAO.removePromotion(promo_id);
        this.mainApp.fillPromotionList(selected_user_id);
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

    private void getUserPromotions(User user) {
        mainApp.fillPromotionList(user.getId());

        SortedList<Promotion> sortedList = new SortedList<>(mainApp.getPromotionList());
        sortedList.comparatorProperty().bind(promotionTable.comparatorProperty());
        promotionTable.setItems(sortedList);
    }
}

package javafx;

import javafx.beans.value.ChangeListener;
import javafx.beans.value.ObservableValue;
import javafx.collections.transformation.FilteredList;
import javafx.collections.transformation.SortedList;
import javafx.event.Event;
import javafx.fxml.FXML;
import javafx.scene.control.*;

public class DashboardController {

    private MainApp mainApp;

    @FXML
    private SplitPane splitPane;

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
    private User selectedUser = null;
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
    private Spinner<Integer> loyaltyPointSpinner;

    private SpinnerValueFactory<Integer> spinnerValueFactory;

    //Fidelity manager
    @FXML
    private TableView<FidelityStep> fidelityStepTable;
    @FXML
    private TableColumn<FidelityStep, String> stepColumn;
    @FXML
    private TableColumn<FidelityStep, String> reductionColumn;
    @FXML
    private TextField stepTextField;
    @FXML
    private TextField reductionTextField;


    @FXML
    private void initialize() {

        splitPane.getDividers().get(0).positionProperty().addListener(new ChangeListener<Number>() {
            @Override
            public void changed(ObservableValue<? extends Number> observable, Number oldValue, Number newValue) {
                splitPane.getDividers().get(0).setPosition(0.25);
            }
        });

        emailColumn.setCellValueFactory(cellData -> cellData.getValue().emailProperty());
        stepColumn.setCellValueFactory(cellData -> cellData.getValue().stepProperty());
        reductionColumn.setCellValueFactory(cellData -> cellData.getValue().reductionProperty());

        showUserDetail(null);

        userTable.getSelectionModel().selectedItemProperty().addListener(
                (observable, oldValue, newValue) -> showUserDetail(newValue)
        );

    }

    public void setMainApp(MainApp main) {
        this.mainApp = main;

        initUserTableFilter();
        initFidelityStepTable();
    }

    public void setLoginUser(User loginUser) {
        this.loginUser = loginUser;
        loginLabel.setVisible(true);
        loginLabel.setText("Bienvenue : " + this.loginUser.getFirstname() + " " + this.loginUser.getLastname());
    }

    private void showUserDetail(User user) {
        if (user != null) {
            spinnerValueFactory = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, 1000, Integer.parseInt(user.getLoyalty_point()));
            selectedUser = user;
            emailLabel.setText(user.getEmail());
            firstnameLabel.setText(user.getFirstname());
            lastnameLabel.setText(user.getLastname());
            roleLabel.setText(user.getRole());
            orderLabel.setText(user.getOrder());
            loyaltyPointSpinner.setValueFactory(spinnerValueFactory);
        } else {
            selectedUser = null;

            emailLabel.setText("");
            firstnameLabel.setText("");
            lastnameLabel.setText("");
            roleLabel.setText("");
            orderLabel.setText("");
        }
    }

    private void initUserTableFilter() {
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

    private void initFidelityStepTable() {
        SortedList<FidelityStep> sortedList = new SortedList<>(mainApp.getFidelityStepList());
        sortedList.comparatorProperty().bind(fidelityStepTable.comparatorProperty());

        fidelityStepTable.setItems(sortedList);
    }

    public void refreshFidelityStepTable() {
        mainApp.refreshFidelityStepList();
    }

    public void updateLoyaltyPoint(Event event) {
        mainApp.dataBaseDAO.updateLoyaltyPoint(Integer.parseInt(selectedUser.getId()), spinnerValueFactory.getValue());
        mainApp.refreshUserList();
    }

    public void deleteFidelityStep() {
        if (!fidelityStepTable.getSelectionModel().isEmpty()) {
            int fidelityStepId = Integer.parseInt(fidelityStepTable.getSelectionModel().getSelectedItem().getId());
            mainApp.dataBaseDAO.deleteFidelityStep(fidelityStepId);
            refreshFidelityStepTable();
        }
    }

    public void addFidelityStep() {
        if (isPositiveNumeric(stepTextField.getText()) && isPositiveNumeric(reductionTextField.getText())) {
            int step = Integer.parseInt(stepTextField.getText());
            int reduction = Integer.parseInt(reductionTextField.getText());
            mainApp.dataBaseDAO.addFidelityStep(step, reduction, Integer.parseInt(loginUser.getId()));
            refreshFidelityStepTable();
        }
    }


    public static boolean isPositiveNumeric(String strNum) {
        if (strNum == null) {
            return false;
        }
        try {
            int d = Integer.parseInt(strNum);
            return d > 0;
        } catch (NumberFormatException nfe) {
            return false;
        }
    }
}

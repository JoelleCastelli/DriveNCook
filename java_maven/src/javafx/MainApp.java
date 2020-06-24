package javafx;

import javafx.application.Application;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.image.Image;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

import java.io.IOException;
import java.util.Collections;

public class MainApp extends Application {

    public static void main(String[] args) {

        launch(args);
    }

    private Stage primaryStage;

    private BorderPane rootLayout;
    public javafx.DataBaseDAO dataBaseDAO;
    private ObservableList<javafx.User> userList = FXCollections.observableArrayList();

    private ObservableList<javafx.FidelityStep> fidelityStepList = FXCollections.observableArrayList();

    @Override
    public void start(Stage stage) throws Exception {
        this.primaryStage = stage;
        primaryStage.setResizable(false);
        primaryStage.setTitle("Drive 'N' Cook Corporate Login");

        dataBaseDAO = new javafx.DataBaseDAO();

        initRootLayout();

        showLoginView();
    }

    public void initRootLayout() {
        try {
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(getClass().getResource("/root.fxml"));
            rootLayout = (BorderPane) loader.load();

            // Show the scene containing the root layout.
            Scene scene = new Scene(rootLayout);
            primaryStage.getIcons().add(new Image(getClass().getResourceAsStream("/images/logo1.png")));
            primaryStage.setScene(scene);
            primaryStage.show();
        } catch (IOException e) {
            e.printStackTrace();
        }

    }

    public void showLoginView() {
        try {
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(getClass().getResource("/login.fxml"));

            AnchorPane loginOverview = (AnchorPane) loader.load();
            rootLayout.setCenter(loginOverview);

            javafx.LoginController loginController = loader.getController();
            loginController.setMainApp(this);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public void showUserListView(User loginUser) {

        userList.addAll(dataBaseDAO.getUserListDB());
        fidelityStepList.addAll(dataBaseDAO.getFidelityStepListDB());

        try {
            primaryStage.setTitle("Drive 'N' Cook Dashboard");
            // Load person overview.
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(getClass().getResource("/dashboard.fxml"));

            AnchorPane personOverview = (AnchorPane) loader.load();
            // Set person overview into the center of root layout.
            rootLayout.setCenter(personOverview);

            DashboardController controller = loader.getController();
            controller.setLoginUser(loginUser);
            controller.setMainApp(this);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public void refreshFidelityStepList() {
        fidelityStepList.clear();
        fidelityStepList.addAll(dataBaseDAO.getFidelityStepListDB());
    }

    public ObservableList<javafx.FidelityStep> getFidelityStepList() {
        return fidelityStepList;
    }

    public void refreshUserList() {
        userList.clear();
        userList.addAll(dataBaseDAO.getUserListDB());
    }

    public void removeFidelityStepItem(String id) {
        fidelityStepList.removeIf(obj -> obj.getId().equals(id));
    }

    public void addFidelityStepItem(FidelityStep fidelityStep) {
        fidelityStepList.add(fidelityStep);
        Collections.sort(fidelityStepList);
    }

    public void updateUserLoyaltyPoint(String userId, String loyaltyPoints) {
        userList.get(getIndexOfUserListById(userId)).setLoyaltyPoint(loyaltyPoints);
    }

    public int getIndexOfUserListById(String id) {
        for (int i = 0; i < userList.size(); i++) {
            if (userList.get(i).getId().equals(id)) {
                return i;
            }
        }
        return -1;
    }

    public ObservableList<javafx.User> getUserList() {
        return userList;
    }
}

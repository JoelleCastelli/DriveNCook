package javafx;

import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;

public class User {
    private final StringProperty id;
    private final StringProperty email;
    private final StringProperty firstname;
    private final StringProperty lastname;
    private final StringProperty role;
    private final StringProperty loyalty_point;
    private final StringProperty order;

    public User() {
        this(null, null, null, null, null, -1, -1);
    }

    public User(String id, String email, String firstname, String lastname, String role, int loyalty_point, int order) {
        this.id = new SimpleStringProperty(id);
        this.email = new SimpleStringProperty(email);
        this.firstname = new SimpleStringProperty(firstname);
        this.lastname = new SimpleStringProperty(lastname);
        this.role = new SimpleStringProperty(role);
        this.loyalty_point = new SimpleStringProperty(String.valueOf(loyalty_point));
        this.order = new SimpleStringProperty(String.valueOf(order));
    }

    public String getId() {
        return id.get();
    }

    public StringProperty idProperty() {
        return id;
    }

    public void setId(String id) {
        this.id.set(id);
    }

    public String getLoyalty_point() {
        return loyalty_point.get();
    }

    public StringProperty loyalty_pointProperty() {
        return loyalty_point;
    }

    public void setLoyalty_point(String loyalty_point) {
        this.loyalty_point.set(loyalty_point);
    }

    public String getOrder() {
        return order.get();
    }

    public StringProperty orderProperty() {
        return order;
    }

    public void setOrder(String order) {
        this.order.set(order);
    }

    public String getEmail() {
        return email.get();
    }

    public StringProperty emailProperty() {
        return email;
    }

    public void setEmail(String email) {
        this.email.set(email);
    }

    public String getFirstname() {
        return firstname.get();
    }

    public StringProperty firstnameProperty() {
        return firstname;
    }

    public void setFirstname(String firstname) {
        this.firstname.set(firstname);
    }

    public String getLastname() {
        return lastname.get();
    }

    public StringProperty lastnameProperty() {
        return lastname;
    }

    public void setLastname(String lastname) {
        this.lastname.set(lastname);
    }

    public String getRole() {
        return role.get();
    }

    public StringProperty roleProperty() {
        return role;
    }

    public void setRole(String role) {
        this.role.set(role);
    }
}

package javafx;

import org.apache.commons.codec.digest.DigestUtils;

import java.nio.charset.StandardCharsets;
import java.sql.*;
import java.util.ArrayList;

public class DataBaseDAO {
    private String url = "jdbc:mysql://134.122.107.73:3306/drivencook";
    private String user = "mysql";
    private String db_password = "ESGIgroupe6";
    private Connection cn = null;
    private PreparedStatement ps = null;
    private Statement st = null;
    private ResultSet rs = null;


    public ArrayList<javafx.User> getUserListDB() {
        ArrayList<javafx.User> userList = new ArrayList<javafx.User>();

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, db_password);

            st = cn.createStatement();

            String sql = "select user.id, email, firstname, lastname, role, loyalty_point, count(sale.id) as orders from user " +
                    "left join sale on user.id = sale.user_client where user.role = 'Client' group by user.id order by email";

            rs = st.executeQuery(sql);

            while (rs.next()) {
                javafx.User userN = new javafx.User(
                        rs.getString("id"),
                        rs.getString("email"),
                        rs.getString("firstname"),
                        rs.getString("lastname"),
                        rs.getString("role"),
                        rs.getInt("loyalty_point"),
                        rs.getInt("orders")
                );
                userList.add(userN);
            }


        } catch (SQLException e) {
            e.printStackTrace();
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        } finally {
            try {
                cn.close();
                st.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return userList;
    }

    public ArrayList<javafx.FidelityStep> getFidelityStepListDB() {
        ArrayList<javafx.FidelityStep> fidelityStepList = new ArrayList<>();

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, db_password);

            st = cn.createStatement();

            String sql = "select id, step, reduction, user_id from fidelity_step order by step";

            rs = st.executeQuery(sql);

            while (rs.next()) {
                javafx.FidelityStep fidelityN = new javafx.FidelityStep(
                        rs.getString("id"),
                        rs.getString("step"),
                        rs.getString("reduction"),
                        rs.getString("user_id")
                );
                fidelityStepList.add(fidelityN);
            }


        } catch (SQLException e) {
            e.printStackTrace();
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        } finally {
            try {
                cn.close();
                st.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return fidelityStepList;
    }

    public User Login(String email, String password) {
        String hashed_password = DigestUtils.sha256Hex(password);

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, db_password);

            String sql = "SELECT id, email,firstname,lastname,role FROM user WHERE email = ? AND password = ? AND role IN ('Administrateur', 'Corporate')";
            ps = cn.prepareStatement(sql);
            ps.setString(1, email);
            ps.setString(2, hashed_password);

            rs = ps.executeQuery();

            if (rs.next()) {
                return new User(
                        rs.getString("id"),
                        rs.getString("email"),
                        rs.getString("firstname"),
                        rs.getString("lastname"),
                        rs.getString("role"),
                        0,
                        0
                );
            } else {
                return null;
            }

        } catch (SQLException e) {
            e.printStackTrace();
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        } finally {
            try {
                cn.close();
                ps.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return null;
    }

    public int updateLoyaltyPoint(int user_id, int loyalty_point) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, db_password);

            String sql = "UPDATE user SET loyalty_point = ? WHERE id = ?";
            ps = cn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS);
            ps.setInt(1, loyalty_point);
            ps.setInt(2, user_id);

            if (ps.executeUpdate() == 1) {
                return 1;
            }
        } catch (SQLException e) {
            e.printStackTrace();
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        } finally {
            try {
                cn.close();
                ps.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return 0;
    }

    public int addFidelityStep(int step, int reduction, int user_id) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, db_password);

            String sql = "insert into fidelity_step (step, reduction, user_id) VALUES (?,?,?)";
            ps = cn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS);
            ps.setInt(1, step);
            ps.setInt(2, reduction);
            ps.setInt(3, user_id);

            if (ps.executeUpdate() == 1) {
                ResultSet rs = ps.getGeneratedKeys();
                if (rs.next()) {
                    return rs.getInt(1);
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        } finally {
            try {
                cn.close();
                ps.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return 0;
    }

    public int deleteFidelityStep(int id) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, db_password);

            String sql = "DELETE FROM fidelity_step WHERE id = ?";
            ps = cn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS);
            ps.setInt(1, id);

            if (ps.executeUpdate() == 1) {
                return 1;
            }
        } catch (SQLException e) {
            e.printStackTrace();
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        } finally {
            try {
                cn.close();
                ps.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return 0;
    }
}

